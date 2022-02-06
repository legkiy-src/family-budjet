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
            $table->dateTime('operation_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Дата операции');
            $table->integer('operation_type')->comment('тип операции');
            $table->bigInteger('account_id')->comment('id счета');
            $table->bigInteger('article_id')->comment('id статьи');
            $table->bigInteger('operation_sum')->default(0)->comment('Сумма операции');
            $table->bigInteger('account_decrement_id')->nullable()->comment('счет списания');
            $table->bigInteger('account_increment_id')->nullable()->comment('счет поступления');
            $table->string('description')->default('')->comment('Описание');
            $table->index('user_id');
            $table->index('operation_date');
            $table->index('operation_type');
            $table->index('account_id');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE account_balances comment 'Остатки на счетах'");
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
