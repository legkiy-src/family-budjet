<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->bigInteger('account_id')->comment('id счета');
            $table->integer('operation_type_id')->comment('id типа операции');
            $table->bigInteger('sum')->default(0)->comment('Сумма операции');
            $table->string('source_table_name')->comment('Таблица источник операции');
            $table->bigInteger('source_table_id')->nullable()->comment('id записи в таблице источника операции');
            $table->string('description')->nullable()->default('')->comment('Описание');
            $table->index('user_id');
            $table->index('account_id');
            $table->index('operation_type_id');
            $table->index('sum');
            $table->index('source_table_name');
            $table->index('source_table_id');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE accounts IS 'Операции'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operations');
    }
}
