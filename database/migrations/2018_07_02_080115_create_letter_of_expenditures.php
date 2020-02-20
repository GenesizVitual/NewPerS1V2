<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLetterOfExpenditures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('letter_of_expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sector_id')->unsigned();
            $table->string('no_surat_pengeluaran');
            $table->date('tgl_surat_keluar');
            $table->text('prihal');
            $table->integer('ditujukan')->unsigned();
            $table->text('isi_surat');
            $table->text('penutup_surat');
            $table->integer('pengguna_barang')->unsigned();
            $table->string('id_pengeluaran',255);
            $table->date('tgl_cetak');
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('letter_of_expenditures', function (Blueprint $table){
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
        Schema::dropIfExists('letter_of_expenditures');
    }
}
