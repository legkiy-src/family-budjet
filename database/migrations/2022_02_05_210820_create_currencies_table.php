<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->string('name')->default('')->comment('Название валюты');
            $table->string('symbol')->default('')->comment('Обозначение');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE accounts IS 'Валюты'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
