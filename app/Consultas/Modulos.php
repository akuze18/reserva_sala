<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 12:07
 */

namespace App\Consultas;


use App\Modulo;

class Modulos {
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function todos(){
        return Modulo::all();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allByHora(){
        return Modulo::orderBy('hora_inicio')->get();
    }
}