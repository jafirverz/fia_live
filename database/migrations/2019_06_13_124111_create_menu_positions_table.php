<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('menu_name')->nullable();
			$table->boolean('view_order')->nullable();
			$table->boolean('status')->comment('0 => Deactivate, 1 => Activate')->default(0)->nullable();
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
        Schema::dropIfExists('menu_positions');
    }
}
