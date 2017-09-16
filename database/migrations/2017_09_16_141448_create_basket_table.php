<?php

use App\Http\Controllers\Classes\BasketClass;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBasketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(BasketClass::TABLE_NAME, function (Blueprint $table) {
            $table->increments(BasketClass::ID);
            $table->integer(BasketClass::ID_KLIENT)->unsigned();
            $table->integer(BasketClass::ID_LIBRI)->unsigned();
            $table->smallInteger(BasketClass::STATUS);

        });

        Schema::table(BasketClass::TABLE_NAME, function (Blueprint $table){
            $table->foreign('id_klient')->references('klient_id')->on('klient');
            $table->foreign('id_libri')->references('libri_id')->on('libri');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
