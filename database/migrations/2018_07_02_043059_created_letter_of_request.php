<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatedLetterOfRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sector_id')->unsigned();
            $table->string('no_surat_permintaan')->nullable();
            $table->date('tgl_surat');
            $table->text('prihal_surat');
            $table->integer('ditujuan')->unsigned();
            $table->text('isi_surat');
            $table->text('penutup_surat');
            $table->integer('pengguna_barang')->unsigned();
            $table->integer('kepala_bidang')->unsigned();
            $table->string('id_barang');
            $table->integer('user_id')->unsigned();
            $table->date('tgl_cetak');
            $table->timestamps();
        });

        Schema::table('letter_of_request', function (Blueprint $table){
           $table->foreign('sector_id')->references('id')->on('sector');
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
        Schema::dropIfExists('letter_of_request');
    }
}
