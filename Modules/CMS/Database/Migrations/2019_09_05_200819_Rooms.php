<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('js_rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('display_order');
            $table->string('name', 100);
            $table->text('short_name')->nullable();
            $table->text('description')->nullable();
            $table->text('general_instructions')->nullable();
            $table->string('logo');
            $table->integer('max_capacity');
            $table->float('price_per_head')->default('0.0');
            $table->float('full_price')->default('0.0');
            $table->string('seo_url', 100);
            $table->integer('js_id')->unsigned();
            $table->integer('js_type')->unsigned();
            $table->json('amenities')->nullable();
            $table->string('meta_title', 100)->nullable();
            $table->string('meta_description', 250)->nullable();
            $table->string('meta_keywords', 250)->nullable();

            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('js_id')->references('id')->on('jungle_stays');
            $table->foreign('js_type')->references('id')->on('js_room_types');
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
