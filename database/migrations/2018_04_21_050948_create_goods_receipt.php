<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsReceipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goodReceipt', function (Blueprint $table) {
            $table->increments('id');
            $table->date('dateOfpurchase');
            $table->integer('warehouse_id')->unsigned();
            $table->decimal('unitPrice',12,2);
            $table->decimal('amountOfgoods',12,2);
            $table->string('nomor_factur')->nullable();
            $table->date('date_factur')->nullable();
            $table->integer('suppliers_id')->unsigned();
            $table->decimal('totalPrice',12,2);
            $table->integer('tbk_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('status')->unsigned();
            $table->timestamps();
        });

        Schema::table('goodReceipt',function (Blueprint $table){
            $table->foreign('warehouse_id')->references('id')->on('warehouse');
            $table->foreign('suppliers_id')->references('id')->on('suppliers');
            $table->foreign('tbk_id')->references('id')->on('tbk');
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
        Schema::dropIfExists('goodReceipt');
    }
}
