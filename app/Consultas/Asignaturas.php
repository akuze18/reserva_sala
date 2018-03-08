<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 11:53
 */

namespace App\Consultas;


use App\Asignatura;

class Asignaturas {
    /**
     * @param $carrera_id integer
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function byCarrera($carrera_id){
        return Asignatura::where('carrera_id',$carrera_id);
    }

    /**
     * @param $carrera_id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getByCarrera($carrera_id){
        return $this->byCarrera($carrera_id)->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allByName(){
        return Asignatura::orderBy('name')->get();
    }
}