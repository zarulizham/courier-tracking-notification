<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracking_codes', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('courier_id')->unsigned();
            $table->foreign('courier_id')->references('id')->on('couriers');

            $table->string('code', 200);
            $table->string('email', 120)->nullable();

            $table->dateTime('last_checked_at')->default(now());
            $table->dateTime('completed_at')->nullable();

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
        Schema::dropIfExists('tracking_codes');
    }
}
