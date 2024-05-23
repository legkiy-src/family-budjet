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
            $table->integer('operation_type_id')->comment('id типа операции');
            $table->string('name')->comment('Наименование');
            $table->string('description')->nullable()->default('')->comment('Описание');
            $table->index('user_id');
            $table->timestamps();
        });

        DB::statement("COMMENT ON TABLE accounts IS 'Статьи доходов/расходов'");
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
