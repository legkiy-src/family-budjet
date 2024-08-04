<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->string('name')->default('')->comment('Имя');
            $table->bigInteger('balance')->default(0)->comment('Баланс');
            $table->integer('currency_id')->nullable()->comment('id из справочника валют');
            $table->string('description')->nullable()->default('')->comment('Описание');
            $table->index('user_id');
            $table->index('currency_id');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE accounts IS 'Счета'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
