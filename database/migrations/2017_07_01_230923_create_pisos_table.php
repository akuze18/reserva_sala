<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pisos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('edificio_id');
            $table->timestamps();
            $table->foreign('edificio_id')->references('id')->on('edificios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pisos');
    }
}
