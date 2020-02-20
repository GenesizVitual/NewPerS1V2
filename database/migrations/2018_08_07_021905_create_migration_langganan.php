<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMigrationLangganan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('langganan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('paket_harga_id')->unsigned();
            $table->integer('priode_paket_id')->unsigned();
            $table->date('begin_date');
            $table->date('end_date');
            $table->tinyInteger('status')->unsigned();
            $table->tinyInteger('status_aktif')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('langganan', function (Blueprint $table){
           $table->foreign('paket_harga_id')->references('id')->on('paket_price');
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
        Schema::dropIfExists('langganan');
    }
}
