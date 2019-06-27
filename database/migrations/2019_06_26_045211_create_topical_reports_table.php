<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicalReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
		Schema::create('topical_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('topical_id')->nullable();
			$table->string('title')->nullable();
			$table->string('banner_image')->nullable();
			$table->string('pdf')->nullable();
			$table->text('description')->comment('HTML contents')->nullable();
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
        Schema::dropIfExists('topical_reports');
    }
}
