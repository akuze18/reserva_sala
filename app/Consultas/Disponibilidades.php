<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 13:43
 */

namespace App\Consultas;


use App\Disponibilidad;

class Disponibilidades {

    /**
     * @param $disponibilidad_id
     * @return \App\Disponibilidad|null
     */
    public function getById($disponibilidad_id){
        return Disponibilidad::where('id',$disponibilidad_id)->first();
    }

    /**
     * @param $horario_id integer
     * @param $sala_id integer
     * @return Disponibilidad|null
     */
    public function getByHorarioSala($horario_id,$sala_id){
        return Disponibilidad::where('horario_id',$horario_id)->where('sala_id',$sala_id)->first();
    }
}