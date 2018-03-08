<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisponibilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disponibilidades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('horario_id');
            $table->unsignedInteger('sala_id');
            $table->enum('estado',['Disponible','Ocupado','Pendiente','Deshabilitado']);
            $table->timestamps();
            $table->foreign('horario_id')->references('id')->on('horarios')->onDelete('cascade');
            $table->foreign('sala_id')->references('id')->on('salas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disponibilidades');
    }
}
