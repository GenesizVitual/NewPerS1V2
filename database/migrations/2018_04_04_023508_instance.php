<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Instance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('province_id')->unsigned();
            $table->integer('district_id')->unsigned();
            $table->string('instance')->nullable();
            $table->text('alamat');
            $table->string('no_telp')->nullable();
            $table->string('fax')->nullable();
            $table->tinyInteger('tingkat')->unsigned()->default(0);
            $table->string('logo')->nullable();
           // $table->timestamps();
        });

        Schema::table('instance', function (Blueprint $table){
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('instance');
    }
}
