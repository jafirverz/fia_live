<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title')->nullable();
            $table->integer('view_order')->default(0)->nullable();
            $table->integer('main')->default(0)->nullable();
            $table->integer('parent')->nullable();
            $table->integer('child')->nullable();
            $table->integer('page_id')->nullable();
			$table->boolean('target_value')->nullable();
			$table->string('external_link')->nullable();
			$table->boolean('menu_type')->nullable();
            $table->boolean('status')->comment('0 => Deactivate, 1 => Activate')->default(1)->nullable();
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
        Schema::dropIfExists('menus');
    }
}
