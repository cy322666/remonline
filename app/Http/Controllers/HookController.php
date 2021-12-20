<?php

namespace App\Http\Controllers;

use App\Models\Access;
use App\Models\Lead;
use App\Services\amoCRM\Client;
use App\Services\amoCRM\EloquentStorage;
use Illuminate\Http\Request;
use App\Services\Remonline\Client as Remonline;

class HookController extends Controller
{
    //https://damirski.notion.site/0cea937855284476a734fc7427648176

    private static int $default_branch_id     = 45740;
    private static int $default_order_type_id = 76239;

    public function hook(Request $request)
    {
        $remonline = (new Remonline(env('REMONLINE_API_KEY')));

        $amocrm = (new Client())->init(new EloquentStorage([], Access::find(1)));

        $lead = $amocrm->service
            ->leads()
            ->find($request->toArray()['status'][0]['id']);

        if($lead) {

            $model = Lead::create([
                'lead_id'    => $lead->id,
                'responsible_user_id' => $lead->responsible_user_id,
                'status_id'  => $lead->status_id,
                'pipeline_id'=> $lead->pipeline_id,
                'contact_id' => $lead->contact->id ?? null,
                'name'       => $lead->contact->name ?? null,
                'phone'      => $lead->cf('Телефон')->getValue(),
                'email'      => $lead->cf('Email')->getValue(),
                'brand'      => $lead->contact->cf('Марка')->getValue(),
                'model'      => $lead->contact->cf('Модель')->getValue(),
                'year_issue' => $lead->contact->cf('Год выпуска')->getValue(),
                'services'   => $lead->cf('Услуга')->getValue(),
                'date_entry' => $lead->cf('Дата установки/встречи')->getValue(),
                'status'     => 'Добавлено',
            ]);

            try {

                $client = $remonline->service
                    ->clients()
                    ->search(['phones[]' => $model->phone]);

                if($client == null) {

                    $client = $remonline->service
                        ->clients()
                        ->create([
                            'phone[]' => '79998887744',
                            'email[]' => 'test@ya.ru',
                            'name'    => 'test',
                        ]);
                }

                $model->rm_client_id = $client['id'];

                $order = $remonline->service
                    ->orders()
                    ->create([
                        'branch_id'  => static::$default_branch_id,
                        'order_type' => static::$default_order_type_id,
                        'brand'      => $model->brand,
                        'model'      => $model->model,
                        'client_id'  => $model->rm_client_id,
                        'status_id'  => '',//TODO
                        'custom_fields' => json_encode([
                            '956779'  => $model->year_issue,//год выпуска
                            '1265785' => $model->date_entry,//date('d.m.Y'),//дата
                            '2046049' => $model->services,//произведенные услуги
                        ]),
                    ]);

                $order = $remonline->service
                    ->orders()
                    ->send();

                $model->rm_order_id = $order['id'];
                $model->status = 'Отправлено';
                $model->save();

            } catch (\Exception $exception) {

                $model->status = $exception->getMessage().' '.$exception->getLine();
                $model->save();
            }
        }
    }
}
