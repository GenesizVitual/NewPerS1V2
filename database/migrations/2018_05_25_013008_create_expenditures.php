<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenditures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->date('out_date');
            $table->integer('goodreceipt_id')->unsigned();
            $table->integer('warehouse_id')->unsigned();
            $table->decimal('exit_item', 12,2);
            $table->integer('sector_id')->unsigned();
            $table->text('information')->nullable();
            $table->tinyInteger('status_surat_permintaan')->default(0);
            $table->tinyInteger('status_surat_pengeluaran')->default(0);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('expenditures', function (Blueprint $table){
            $table->foreign('goodreceipt_id')->references('id')->on('goodreceipt')->onDelete('cascade');
            $table->foreign('warehouse_id')->references('id')->on('warehouse');
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
        Schema::dropIfExists('expenditures');
    }
}
