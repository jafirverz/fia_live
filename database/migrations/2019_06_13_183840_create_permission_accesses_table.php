<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_accesses', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('role_id')->nullable();
			$table->string('module');
			$table->boolean('views')->nullable();
			$table->boolean('creates')->nullable();
			$table->boolean('edits')->nullable();
			$table->boolean('deletes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permission_accesses');
    }
}
