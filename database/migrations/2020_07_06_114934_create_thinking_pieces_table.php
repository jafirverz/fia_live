<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThinkingPiecesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thinking_pieces', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('thinking_piece_title')->nullable();
			$table->timestamp('thinking_piece_date')->nullable();
			$table->string('thinking_piece_image')->nullable();
			$table->string('thinking_piece_address')->nullable();
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
        Schema::dropIfExists('thinking_pieces');
    }
}
