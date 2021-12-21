<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->integer('lead_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->integer('status_id')->nullable();
            $table->integer('pipeline_id')->nullable();
            $table->integer('responsible_user_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('year_issue')->nullable();
            $table->string('services')->nullable();
            $table->string('date_entry')->nullable();
            $table->integer('rm_order_id')->nullable();
            $table->integer('rm_client_id')->nullable();
            $table->string('status')->nullable();

            $table->index('lead_id');
            $table->index('status');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
}
