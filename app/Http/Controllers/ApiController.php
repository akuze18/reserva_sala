<?php

namespace App\Http\Controllers;

use App\CargaAcademica;
use App\Carrera;
use App\Dia;
use App\Disponibilidad;
use App\Edificio;
use App\Horario;
use App\Modulo;
use App\Piso;
use App\Sala;
use App\Solicitud;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getPisos(Request $request){
        if($request->has('edificioId')){
            $id_edificio = $request->get('edificioId');
        }
        else{
            $id_edificio = $request->get('parentId');
        }

        $edificio = Edificio::where('id',$id_edificio)->first();
        $contenido = '<option selected disabled></option>';
        foreach($edificio->pisos as $piso){
            $contenido .= '<option value="'.$piso->id.'">'.$piso->name.'</option>';
        }
        return $contenido;
    }
    public function getSalas(Request $request){

        $id_piso = $request->get('parentId');
        $piso = Piso::where('id',$id_piso)->first();
        $contenido = '<option selected disabled></option>';
        foreach($piso->salas as $salas){
            $contenido .= '<option value="'.$salas->id.'">'.$salas->name.'</option>';
        }
        return $contenido;
    }
    public function getAsignaturas(Request $request){
        $id_carrera = $request->get('parentId');
        $carrera = Carrera::where('id',$id_carrera)->first();
        $contenido = '<option selected disabled></option>';
        foreach($carrera->asignaturas as $asignatura){
            $contenido .= '<option value="'.$asignatura->id.'">'.$asignatura->name.'</option>';
        }
        return $contenido;
    }
}
