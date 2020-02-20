<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMutasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutasi', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tgl_transaksi');
            $table->integer('warehouse_id')->unsigned()->default(0);
            $table->integer('goodreceipt_id')->unsigned()->default(0);
            $table->integer('expenditures_id')->unsigned()->default(0);
            $table->decimal('last_stock',12,2)->default(0);
            $table->decimal('jum_in',12,2)->default(0);;
            $table->decimal('jum_out',12,2)->default(0);;
            $table->decimal('remaining_stok',12,2)->default(0);;
            $table->decimal('total_start',12,2)->default(0);;
            $table->decimal('total_final',12,2)->default(0);;
            $table->decimal('total',12,2)->default(0);;
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('mutasi', function (Blueprint $table){
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
        Schema::dropIfExists('mutasi');
    }
}
