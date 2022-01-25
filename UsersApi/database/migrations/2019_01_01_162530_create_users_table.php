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
            $table->increments('id');
            $table->string('lastName', 255)->nullable();
            $table->string('firstName', 255)->nullable();
            $table->string('userName', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 32)->nullable();
            $table->integer('birthday')->unsigned()->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('level', 255)->nullable();
            $table->enum('type', ['PARENT', 'ELEVE', 'ADMINISTRATEUR'])->default('ELEVE');
            $table->string('currentSchool', 255)->nullable();
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
