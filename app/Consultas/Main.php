<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 11:15
 */

namespace App\Consultas;


use App\Logs\Consultas as Log;

class Main {
    private $consultas;

    public function __construct(){
        $this->consultas = [
            'docente'       => new Docentes(),
            'alumno'        => new Alumnos(),
            'horario'       => new Horarios(),
            'dia'           => new Dias(),
            'asignatura'    => new Asignaturas(),
            'modulo'        => new Modulos(),
            'edificio'      => new Edificios(),
            'piso'          => new Pisos(),
            'sala'          => new Salas(),
            'carrera'       => new Carreras(),
            'dispon'        => new Disponibilidades(),
            'motivo'        => new Motivos(),
            'usuario'       => new Usuarios(),
            'log'           => new Log()
        ];
    }

    /**
     * @return \App\Logs\Consultas
     */
    public function logs(){return $this->consultas['log'];}

    /**
     * @return \App\Consultas\Usuarios
     */
    public function usuarios(){return $this->consultas['usuario'];}

    /**
     * @return \App\Consultas\Motivos
     */
    public function motivos(){return $this->consultas['motivo'];}

    /**
     * @return \App\Consultas\Disponibilidades
     */
    public function disponibilidades(){return $this->consultas['dispon'];}

    /**
     * @return \App\Consultas\Alumnos
     */
    public function alumnos(){return $this->consultas['alumno'];}

    /**
     * @return \App\Consultas\Carreras
     */
    public function carreras(){return $this->consultas['carrera'];}

    /**
     * @return \App\Consultas\Docentes
     */
    public function docentes(){return $this->consultas['docente'];}

    /**
     * @return \App\Consultas\Horarios
     */
    public function horarios(){return $this->consultas['horario'];}

    /**
     * @return \App\Consultas\Dias
     */
    public function dias(){return $this->consultas['dia'];}

    /**
     * @return \App\Consultas\Asignaturas
     */
    public function asignaturas(){return $this->consultas['asignatura'];}

    /**
     * @return \App\Consultas\Modulos
     */
    public function modulos(){return $this->consultas['modulo'];}

    /**
     * @return \App\Consultas\Edificios
     */
    public function edificios(){return $this->consultas['edificio'];}
    /**
     * @return \App\Consultas\Pisos
     */
    public function pisos(){return $this->consultas['piso'];}

    /**
     * @return \App\Consultas\Salas
     */
    public function salas(){return $this->consultas['sala'];}
}