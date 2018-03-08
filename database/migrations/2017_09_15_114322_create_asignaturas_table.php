<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaturas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',150)->unique();
            $table->string('name');
            $table->unsignedInteger('nivel_id');
            $table->unsignedInteger('carrera_id');
            $table->timestamps();
            $table->foreign('nivel_id')->references('id')->on('nivels');
            $table->foreign('carrera_id')->references('id')->on('carreras');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignaturas');
    }
}
