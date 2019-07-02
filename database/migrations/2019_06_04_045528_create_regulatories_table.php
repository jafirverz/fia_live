<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegulatoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulatories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->unique();
            $table->string('slug');
            $table->boolean('highlight')->default(0)->nullable()->comment('0 -> Not Highlighted, 1 -> Highlighted');
            $table->string('agency_responsible');
            $table->date('date_of_regulation_in_force');
            $table->text('description')->nullable();
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('topic_id');
            $table->integer('country_id');
            $table->foreign('topic_id')->references('id')->on('topics');
            $table->foreign('country_id')->references('id')->on('topics');
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
        Schema::dropIfExists('regulatories');
    }
}
