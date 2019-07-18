<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_id');
            $table->integer('information_filter_id');
            $table->string('information_title')->unique();
            $table->string('information_title_slug');
            $table->text('information_content');
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
        Schema::dropIfExists('country_information');
    }
}