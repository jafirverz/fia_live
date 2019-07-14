<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('salutation')->nullable();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('organization');
            $table->string('job_title')->nullable();
            $table->string('telephone_code')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('mobile_code')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('subscribe_status')->nullable();
            $table->boolean('member_type')->nullable();
            $table->integer('status')->nullable()->comment('1 -> Pending Email Verification, 2 -> Pending admin approval,
            3 -> Rejected, 4 -> Pending for Payment, 5 -> Active, 6 -> Inactive, 7 -> Lapsed, 8 -> Expired');
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
        Schema::dropIfExists('users');
    }
}
