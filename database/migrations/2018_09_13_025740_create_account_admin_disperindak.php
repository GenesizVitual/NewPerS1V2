<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountAdminDisperindak extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_disperindak', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',255);
            $table->string('password', 255);
            $table->integer('province_id')->unsigned();
            $table->integer('distric_id')->unsigned();
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
        Schema::dropIfExists('user_disperindak');
    }
}
