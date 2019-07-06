<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegulatoryHighlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulatory_highlights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('main_highlight')->nullable();
            $table->integer('other_highlight1')->nullable();
            $table->integer('other_highlight2')->nullable();
            $table->integer('other_highlight3')->nullable();
            $table->integer('other_highlight4')->nullable();
            $table->integer('other_highlight5')->nullable();
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
        Schema::dropIfExists('regulatory_highlights');
    }
}
