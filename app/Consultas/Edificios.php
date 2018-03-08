<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 12:11
 */

namespace App\Consultas;


use App\Edificio;

class Edificios {
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function todos(){
        $algo = Edificio::all();
        return $algo;
    }
}