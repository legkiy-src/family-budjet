<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->integer('family_member_id')->nullable()->comment('id члена семьи');
            $table->tinyInteger('type')->comment('Тип (доход/расход)');
            $table->string('name')->default('Наименование');
            $table->string('description')->default('Описание');
            $table->index('user_id');
            $table->index('family_member_id');
            $table->index('type');
            $table->timestamps();
        });

        DB::statement("ALTER TABLE articles comment 'Статьи расходов/доходов'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
