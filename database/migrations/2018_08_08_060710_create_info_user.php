<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInfoUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_langganan', function (Blueprint $table) {
            $table->increments('id');
            $table->text('msg');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('info_langganan', function (Blueprint $table){
           $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_langganan');
    }
}
