<?php

namespace App\Http\Controllers;

use App\Consultas\Main as Consultas;
use App\Dia;
use App\Horario;
use App\Modulo;
use App\Solicitud;

class PersonalController extends Controller
{
    private $docentes;

    public function __construct(Consultas $consulta){
        $this->docentes = $consulta->docentes();
    }

    public function solicitudes($estado=null){
        $solicitudes = Solicitud::estado($estado)->where('user_id',ActualUser()->id)->paginate(20);
        if(is_null($estado)){$estado='';}
        return view('sistema.personal.solicitudes',compact('solicitudes','estado'));
    }

    public function cargas_academicas(){
        $docente = $this->docentes->firstFailById(actualUser()->id);
        $carga_docente = $docente->cargas_academicas;
        $dias = Dia::where('activo',true)->orderBy('id')->get();
        $modulos = Modulo::all();
        $asignacion = [];
        foreach($dias as $dia){
            $asignacion = array_add($asignacion,$dia->id,[]);
            foreach($modulos as $modulo){
                $horario = Horario::where('modulo_id',$modulo->id)->where('dia_id',$dia->id)->first();
                if(is_null($carga_docente)){$value = null;}
                else{
                    $value = $carga_docente->where('horario_id',$horario->id)->first();
                }

                $asignacion[$dia->id] = array_add($asignacion[$dia->id],$modulo->id,[$horario,$value]);
            }
        }
        return view('sistema.personal.cargas-academicas',compact('docente','dias','modulos','asignacion'));
    }
}
