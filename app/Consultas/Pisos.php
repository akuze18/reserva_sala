<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 12:16
 */

namespace App\Consultas;


use App\Piso;

class Pisos {
    /**
     * @param $edificio_id integer
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByEdificio($edificio_id){
        return Piso::where('edificio_id',$edificio_id)->get();
    }
}