<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('contents')->comment('HTML contents')->nullable();
            $table->integer('sub_contents_id')->comment('Sub Contents id')->nullable();
            $table->string('meta_auther')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->text('meta_description')->nullable();
            $table->tinyInteger('page_type')->length(4)->default(1)->comment('0 => Static, 1 => Semi Dynamic, 2 => Fully Dynamic')->nullable();
            $table->boolean('status')->comment('0 => Deactivate, 1 => Activate')->default(1)->nullable();
            $table->boolean('before_login_status')->comment('0 => Display after login only, 1 => display in all conditions')->default(1)->nullable();
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
        Schema::dropIfExists('pages');
    }
}
