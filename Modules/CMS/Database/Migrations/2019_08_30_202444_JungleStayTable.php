<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JungleStayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('jungle_stays', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->integer('display_order');
        //     $table->string('name', 100);
        //     $table->text('short_desc');
        //     $table->text('description');
        //     $table->text('general_instructions')->nullable();
        //     $table->string('logo');
        //     $table->string('map_url');
        //     $table->string('incharger_details', 200);
        //     $table->string('seo_url', 100);
        //     $table->integer('park_type')->unsigned();
        //     $table->boolean('has_trail')->default(0);
        //     $table->json('trails')->nullable();
        //     $table->boolean('has_safari')->default(0);
        //     $table->json('safaries')->nullable();
        //     $table->string('meta_title', 100);
        //     $table->string('meta_description', 250);
        //     $table->string('meta_keywords', 250);
        //
        //     $table->boolean('status')->default(1);
        //     $table->timestamps();
        //     $table->softDeletes();
        //
        //     $table->foreign('park_type')->references('id')->on('park_types');
        // });
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
