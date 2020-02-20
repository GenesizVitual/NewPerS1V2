<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminInspektoratPemkab extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_inspektorat_pemkab', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account',100);
            $table->string('password',100);
            $table->integer('province_id')->unsigned();
            $table->integer('district_id')->unsigned();
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
        Schema::dropIfExists('admin_inspektorat_pemkab');
    }
}
