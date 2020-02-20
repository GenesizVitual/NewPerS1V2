<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spj', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number_spj');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('spj', function (Blueprint $table){
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
        Schema::dropIfExists('spj');
    }
}
