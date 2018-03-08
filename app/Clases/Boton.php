<?php

namespace App\Clases;

class Boton {

    protected $nombre,$icono,$tipo,$color;

    public function __construct(){
        //obtengo un array con los parámetros enviados a la función
        $params = func_get_args();
        //saco el número de parámetros que estoy recibiendo
        $num_params = func_num_args();
        if($num_params==3){
            $this->tipo = $params[0];
            $this->nombre = $params[1];
            $this->icono = $params[2];
            $this->color = ($this->tipo=='reset'?'danger':'primary');
        }
        elseif($num_params==4){
            $this->tipo = $params[0];
            $this->nombre = $params[1];
            $this->icono = $params[2];
            $this->color = $params[3];
        }
    }

    public function tipo(){
        return $this->tipo;
    }
    public function nombre(){
        return $this->nombre;
    }
    public function icono(){
        return $this->icono;
    }
    public function color(){
        return $this->color;
    }
}