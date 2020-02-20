<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouse extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->increments('id');
            $table->string('goods_code')->nullable();
            $table->string('goods_name');
            $table->string('unit');
            $table->string('specs')->nullable();
            $table->string('brand')->nullable();
            $table->decimal('minimum_stock', 12, 2)->default(0);
            $table->decimal('initial_stock', 12, 2)->default(0);
            $table->decimal('standard_price', 12, 2);
            $table->decimal('total_price', 12, 2);
            $table->timestamps();
        });

        Schema::table('warehouse', function (Blueprint $table){
            $table->integer('typeofgoods_id')->unsigned();
            $table->integer('user_id')->unsigned();

            $table->foreign('typeofgoods_id')->references('id')->on('typeofgoods');
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
        Schema::dropIfExists('warehouse');
    }
}
