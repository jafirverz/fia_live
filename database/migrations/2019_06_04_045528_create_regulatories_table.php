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
            $table->string('title');
            $table->string('slug');
            $table->string('agency_reponsible');
            $table->date('date_of_regulation_in_force')->nullable();
            $table->date('regulatory_date')->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->nullable()->default(0);
            $table->string('topic_id')->nullable();
			$table->integer('topic_id')->nullable();
            $table->string('country_id')->nullable();
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
