<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_balances', function (Blueprint $table) {
            $table->id()->comment('Первичный ключ');
            $table->bigInteger('user_id')->comment('id пользователя');
            $table->integer('family_member_id')->nullable()->comment('id члена семьи');
            $table->bigInteger('balance')->default(0)->comment('Остаток');
            $table->dateTime('mov_date')->default(DB::raw('CURRENT_TIMESTAMP'))->comment('Дата движения денежных средств');
            $table->string('description')->default('')->comment('Описание');
            $table->index('user_id');
            $table->index('family_member_id');
            $table->index('mov_date');
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
        Schema::dropIfExists('account_balances');
    }
}
