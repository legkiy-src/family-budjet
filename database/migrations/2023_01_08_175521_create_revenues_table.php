<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');;
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->bigInteger('operation_id')->nullable()->comment('id операции');
            $table->bigInteger('account_id')->comment('id счёта');
            $table->bigInteger('article_id')->comment('id статьи дохода');
            $table->bigInteger('total_sum')->default(0)->comment('Сумма дохода');
            $table->string('description')->nullable()->default('')->comment('Описание');
            $table->timestamps();
            $table->index('user_id');
            $table->index('account_id');
            $table->index('article_id');
            $table->index('total_sum');
        });

        DB::statement("COMMENT ON TABLE accounts IS 'Доходы'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenues');
    }
}
