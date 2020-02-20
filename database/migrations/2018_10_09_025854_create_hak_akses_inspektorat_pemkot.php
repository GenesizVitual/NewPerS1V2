<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHakAksesInspektoratPemkot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hak_akses_inspektorat_pemkot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('admin_inspektorat_pemkot')->unsiged();
            $table->integer('instansi_id')->unsiged();
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
        Schema::dropIfExists('hak_akses_inspektorat_pemkot');
    }
}
