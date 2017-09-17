<?php

use App\Http\Controllers\Classes\FeedbackClass;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FeedbackClass::TABLE_NAME, function (Blueprint $table) {
            $table->increments(FeedbackClass::ID);
            $table->string(FeedbackClass::EMRI);
            $table->string(FeedbackClass::EMAIL);
            $table->text(FeedbackClass::DESC);
            $table->smallInteger(FeedbackClass::STATUS);
            $table->timestamps();
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
