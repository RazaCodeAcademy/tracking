<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username');
            $table->string('email')->unique();
            $table->string('date_of_birth');
            $table->string('gender');
            $table->string('placement')->comment('1: left 2:right');
            $table->string('country');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('address');
            $table->string('phone_number')->unique();
            $table->string('cnic');
            $table->string('payment_process');
            $table->string('promoter_id');
            $table->string('mother_name');
            $table->string('favourite_pet');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('pass')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
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