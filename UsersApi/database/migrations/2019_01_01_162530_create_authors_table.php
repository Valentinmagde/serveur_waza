<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lastName', 255);
            $table->string('firstName', 255);
            $table->string('userName', 255);
            $table->string('gender', 20);
            $table->string('country', 20);
            $table->string('password', 255);
            $table->string('email', 255)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('class', 255)->nullable();
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
