<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaAcademicasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_academicas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('docente_id');
            $table->unsignedInteger('asignatura_id');
            $table->unsignedInteger('horario_id');
            $table->unsignedInteger('sala_id');
            $table->timestamps();
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('asignatura_id')->references('id')->on('asignaturas')->onDelete('cascade');
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
        Schema::dropIfExists('carga_academicas');
    }
}
