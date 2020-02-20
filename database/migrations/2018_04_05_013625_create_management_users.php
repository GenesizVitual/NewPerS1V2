<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('management_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 50);
            $table->string('name');
            $table->string('photo');
            $table->string('password');
            $table->timestamps();
        });

        Schema::table('management_users', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
            $table->integer('instance_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('instance_id')->references('id')->on('instance');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('management_users');
    }
}
