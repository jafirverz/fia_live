<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group_name')->unique();
            $table->text('group_members');
            $table->boolean('status')->default(0)->comment('0 -> inactive, 1 -> active');
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
        Schema::dropIfExists('group_managements');
    }
}
