<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudRechazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitud_rechazos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitud_id');
            $table->unsignedInteger('motivo_id');
            $table->timestamps();
            $table->foreign('solicitud_id')
                ->references('id')
                ->on('solicitudes')
                ->onDelete('cascade');
            $table->foreign('motivo_id')
                ->references('id')
                ->on('motivos')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('solicitud_rechazos');
    }
}
