<?php

namespace App\Consultas;

use App\Dia;

class Dias {

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function activos(){
        return Dia::where('activo',true)->orderBy('id');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getActivos(){
        return Dia::where('activo',true)->orderBy('id')->get();
    }
}