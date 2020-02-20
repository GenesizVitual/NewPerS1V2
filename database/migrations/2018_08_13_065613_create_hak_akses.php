<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHakAkses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hak_akses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_bpk_id')->unsigned();
            $table->integer('instansi_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('hak_akses', function (Blueprint $table){
           $table->foreign('admin_bpk_id')->references('id')->on('user_bpk')->onDelete('cascade');
           $table->foreign('instansi_id')->references('id')->on('instance')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hak_akses');
    }
}
