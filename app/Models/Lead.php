<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    //1. Имя
    //2. Телефон
    //3. e-mail
    //4. Марка
    //5. Модель
    //6. Год выпуска
    //7. Услуги
    //8. Дата записи
    protected $fillable = [
        'lead_id',
        'contact_id',
        'status_id',
        'pipeline_id',
        'responsible_user_id',
        'name',
        'phone',
        'email',
        'brand',
        'model',
        'year_issue',
        'services',
        'date_entry',
        'rm_order_id',
        'rm_client_id',
        'status',
    ];
}
