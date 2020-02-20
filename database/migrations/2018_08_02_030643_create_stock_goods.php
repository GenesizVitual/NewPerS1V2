<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockGoods extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_goods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('warehouse_id')->unsigned();
            $table->integer('fiscal_years_id')->unsigned();
            $table->decimal('stock',12, 2);
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_goods');
    }
}
