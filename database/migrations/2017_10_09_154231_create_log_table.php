<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('accion',150);
            $table->string('modulo',150);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('object_id')->nullable();
            $table->unsignedInteger('motivo_id')->nullable();
            $table->string('info_adicional',250)->default('');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('motivo_id')->references('id')->on('motivos')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
