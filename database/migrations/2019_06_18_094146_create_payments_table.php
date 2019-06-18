<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->string('payment_id')->nullable();
			$table->date('payment_date')->nullable();
            $table->date('subscription_date')->nullable();
			$table->boolean('subscription_status')->comment('0 => Deactivate, 1 => Activate')->default(0)->nullable();
            $table->date('renewal_date')->nullable();
			$table->string('payee_email_id')->nullable();
			$table->string('payee_name')->nullable();
			$table->boolean('payment_mode')->comment('0 => Offline, 1 => Online')->nullable();
			$table->boolean('status')->comment('0 => UnPaid, 1 => Paid')->default(0)->nullable();
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
        Schema::dropIfExists('payments');
    }
}
