<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmasiLangganan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirm_langganan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bank_tujuan', 255);
            $table->string('bank_pengirim', 255);
            $table->string('no_rekening_bank', 255);
            $table->string('nama_pengirim', 255);
            $table->date('tanggal_pengirim');
            $table->string('nama_bukti_rekening', 255);
            $table->text('catatan')->nullable();
            $table->decimal('total_transfer',12, 2);
            $table->integer('tagihan_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('confirm_langganan', function (Blueprint $table){
            $table->foreign('tagihan_id')->references('id')->on('langganan');
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
        Schema::dropIfExists('confirm_langganan');
    }
}
