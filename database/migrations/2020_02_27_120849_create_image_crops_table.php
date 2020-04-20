<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageCropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_crops', function (Blueprint $table) {
            $table->bigIncrements('crop_image_id');
            $table->integer('page_image_id');
            $table->integer('image_width')->nullable();
            $table->integer('image_height')->nullable();
            $table->string('image_url');
            $table->integer('user_id');
            $table->string('params');
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
        Schema::dropIfExists('image_crops');
    }
}
