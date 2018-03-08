<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTomadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tomados', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('disponibilidad_id');
            $table->boolean('activo')->default(true);
            $table->integer('tomable_id');
            $table->string('tomable_type');
            $table->timestamps();
            $table->foreign('disponibilidad_id')->references('id')->on('disponibilidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tomados');
    }
}
