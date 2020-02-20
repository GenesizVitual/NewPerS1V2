<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiketBantuan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiket_bantuan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department')->unsigned();
            $table->string('masalah', 255);
            $table->text('penjelasan');
            $table->text('alur_masalah');
            $table->integer('user_id')->unsigned();
            $table->integer('status')->unsigned()->default(0);
            $table->timestamps();
        });

        Schema::table('tiket_bantuan', function (Blueprint $table){
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
        Schema::dropIfExists('tiket_bantuan');
    }
}
