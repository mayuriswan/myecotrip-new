<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JsBookingDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('js_booking_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ref_no');
            $table->integer('booking_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('pricing_id')->unsigned();
            $table->integer('total_guests');
            $table->double('gst_amount', 14,2)->nullable();
            $table->double('total_amount', 14,2)->nullable();
            $table->text('guest_details')->nullable();
            $table->text('entry_details')->nullable();

            $table->string('booking_status')->default('Waiting');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('booking_id')->references('id')->on('js_bookings');
            $table->foreign('room_id')->references('id')->on('js_rooms');
            $table->foreign('pricing_id')->references('id')->on('js_room_pricing');

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
