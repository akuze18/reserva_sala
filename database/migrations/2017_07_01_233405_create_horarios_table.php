<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('modulo_id');
            $table->unsignedInteger('dia_id');
            $table->timestamps();
            $table->foreign('modulo_id')->references('id')->on('modulos')->onDelete('cascade');
            $table->foreign('dia_id')->references('id')->on('dias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios');
    }
}
