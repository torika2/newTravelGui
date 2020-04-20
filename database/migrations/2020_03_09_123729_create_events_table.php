<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('evnt_id');
            $table->string("title_ge");
            $table->string("title_en");
            $table->string("title_ru");
            $table->string("title_ch");
            $table->text("description_ge");
            $table->text("description_en");
            $table->text("description_ru");
            $table->text("description_ch");
            $table->integer("city_id");
            $table->float("price");
            $table->integer("valute_id");
            $table->integer("time");
            $table->integer("time_type_id");
            $table->integer("show_bookmark")->default(0);
            $table->text("book_mark_link")->nullable();
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
        Schema::dropIfExists('events');
    }
}
