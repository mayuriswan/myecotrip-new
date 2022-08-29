<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JsBooking extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('js_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_id');
            $table->integer('user_id')->unsigned();
            $table->integer('js_id')->unsigned();
            $table->dateTime('date_of_booking');
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('total_guests');
            $table->integer('total_vehicles')->default(0);

            $table->double('entry_amount', 14,2)->default(0.0)->nullable();
            $table->double('stay_amount', 14,2)->nullable();
            $table->double('stay_gst', 14,2)->nullable();
            $table->double('parking_amount', 14,2)->nullable();
            $table->double('parking_gst', 14,2)->nullable();
            $table->double('transactional_amount', 14,2)->default(0.0)->nullable();
            $table->double('total_gst_amount', 14,2)->nullable()->comment('Stay + Parking + Entry');
            $table->double('total_amount', 14,2)->nullable()->comment('Stay + Parking + Entry + All GST');

            $table->string('booking_status')->default('Waiting');
            $table->text('gateway_response')->nullable();
            $table->json('vehicle_details')->nullable()->comment('type & price id');
            $table->string('booking_source')->default('Web');
            $table->boolean('has_safari')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('js_id')->references('id')->on('jungle_stays');

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
