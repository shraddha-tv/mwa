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
            $table->string('name');
            $table->string('name_eng')->nullable();
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->default("password");

            $table->unsignedBigInteger('verified_by')->nullable();
            $table->unsignedBigInteger('create_by');
            $table->string('nic')->nullable();
            $table->string('type')->default('farmer');
            $table->unsignedBigInteger('state_id');

            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('state_id')->references('id')->on('states')->onUpdate('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('create_by')->references('id')->on('users')->onUpdate('cascade');
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
