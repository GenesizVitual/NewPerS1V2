<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUserBpk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_bpk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',255);
            $table->string('password', 255);
            $table->integer('province_id')->unsigned();
            $table->integer('distric_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('user_bpk', function (Blueprint $table){
           $table->foreign('province_id')->references('id')->on('province');
           $table->foreign('distric_id')->references('id')->on('district');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_bpk');
    }
}
