<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TriggerGoodrecipt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('
        CREATE TRIGGER `trigger_upwarehouse` AFTER INSERT ON `goodreceipt` FOR EACH ROW 
        Begin 
	       /* DECLARE jumlah_awal decimal DEFAULT 0;
            DECLARE harga_awal decimal DEFAULT 0;
            set jumlah_awal = (select initial_stock from warehouse where id = new.warehouse_id);
            update warehouse set initial_stock=(jumlah_awal+new.amountOfgoods)  where id = new.warehouse_id;*/
   	    END');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::unprepared('Drop trigger `trigger_upwarehouse` ');
    }
}
