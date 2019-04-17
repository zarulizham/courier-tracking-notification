<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_histories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('tracking_code_id')->unsigned();
            $table->foreign('tracking_code_id')->references('id')->on('tracking_codes');

            $table->dateTime('history_date_time');
            $table->text('description')->nullable();
            $table->text('event')->nullable();
            $table->dateTime('email_sent_at')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tracking_histories');
    }
}
