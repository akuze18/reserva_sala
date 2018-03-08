<?php

namespace App\Consultas;


use App\Motivo;

class Motivos {

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function creacion(){
        return Motivo::where('action','creacion')->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function rechazo(){
        return Motivo::where('action','rechazo')->get();
    }

    /**
     * @return \App\Motivo
     */
    public function reasignada(){
        return $this->rechazo()->where('descripcion','Reasignada')->first();
    }
}