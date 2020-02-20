<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingModelSimda extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengeturan_simda', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Kd_Urusan',100);
            $table->string('Kd_Bidang',100);
            $table->string('Kd_Unit',100);
            $table->string('Kd_Sub',100);
            $table->integer('id_instance')->unsigned();
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
        Schema::dropIfExists('pengeturan_simda');
    }
}
