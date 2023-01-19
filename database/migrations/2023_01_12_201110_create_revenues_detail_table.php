<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevenuesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revenues_detail', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->bigInteger('revenue_id')->comment('id дохода');
            $table->bigInteger('article_id')->comment('id статьи дохода');
            $table->bigInteger('sum')->default(0)->comment('Сумма');
            $table->string('description')->nullable()->default('')->comment('Описание');
            $table->timestamps();
            $table->index('user_id');
            $table->index('revenue_id');
            $table->index('article_id');
            $table->index('sum');
        });

        DB::statement("ALTER TABLE revenues_detail comment 'Состав дохода'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('revenues_detail');
    }
}
