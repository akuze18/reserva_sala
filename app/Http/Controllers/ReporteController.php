<?php

namespace App\Http\Controllers;

use App\Consultas\Main as Consultas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class ReporteController extends Controller
{
    private $carreras,$salas,$horarios,$usuarios,$logs;

    public function __construct(Consultas $consultas)
    {
        $this->carreras = $consultas->carreras();
        $this->salas = $consultas->salas();
        $this->horarios = $consultas->horarios();
        $this->usuarios = $consultas->usuarios();
        $this->logs = $consultas->logs();
    }

    public function sala_top(Request $request){
        $desde = ($request->has('desde')?$request->get('desde'):fecha_desde()->format('Y-m-d'));
        $hasta = ($request->has('hasta')?$request->get('hasta'):fecha_hasta()->format('Y-m-d'));
        $info = $this->salas->reporteTop($desde,$hasta,15,15);
        $modo = ($request->has('modo')?$request->get('modo'):'');
        if($modo=='Excel' or $modo=='PDF'){
            $info = $this->salas->reporteTop($desde,$hasta,100);  //vista sin paginar
        }
        $origen = 'sala-top';
        return $this->exeModo($origen,$modo,$desde,$hasta,$info);
    }

    public function horario_top(Request $request){
        $desde = ($request->has('desde')?$request->get('desde'):fecha_desde()->format('Y-m-d'));
        $hasta = ($request->has('hasta')?$request->get('hasta'):fecha_hasta()->format('Y-m-d'));
        $info =$this->horarios->reporteTop($desde,$hasta,15,15);
        $modo = ($request->has('modo')?$request->get('modo'):'');
        if($modo=='Excel' or $modo=='PDF'){
            $info = $this->horarios->reporteTop($desde,$hasta,100);  //vista sin paginar
        }
        $origen = 'horario-top';
        return $this->exeModo($origen,$modo,$desde,$hasta,$info);
    }

    public function solicitante_top(Request $request){
        $desde = ($request->has('desde')?$request->get('desde'):fecha_desde()->format('Y-m-d'));
        $hasta = ($request->has('hasta')?$request->get('hasta'):fecha_hasta()->format('Y-m-d'));
        $info = $this->usuarios->reporteSolicitanteTop($desde,$hasta,15,15);
        $modo = ($request->has('modo')?$request->get('modo'):'');
        if($modo=='Excel' or $modo=='PDF'){
            $info = $this->usuarios->reporteSolicitanteTop($desde,$hasta,100);  //vista sin paginar
        }
        $origen = 'solicitante-top';
        return $this->exeModo($origen,$modo,$desde,$hasta,$info);
    }

    public function carrera_top(Request $request){
        $desde = ($request->has('desde')?$request->get('desde'):fecha_desde()->format('Y-m-d'));
        $hasta = ($request->has('hasta')?$request->get('hasta'):fecha_hasta()->format('Y-m-d'));
        $info = $this->carreras->reporteTop($desde,$hasta,10,15);
        $modo = ($request->has('modo')?$request->get('modo'):'');
        if($modo=='Excel' or $modo=='PDF'){
            $info = $this->carreras->reporteTop($desde,$hasta,100);  //vista sin paginar
        }
        $origen = 'carrera-top';
        return $this->exeModo($origen,$modo,$desde,$hasta,$info);
    }

    public function logs(Request $request){
        $desde = ($request->has('desde')?$request->get('desde'):fecha_desde()->format('Y-m-d'));
        $hasta = ($request->has('hasta')?$request->get('hasta'):fecha_hasta()->format('Y-m-d'));
        $logs = $this->logs->reporte($desde,$hasta,15);
        $modo = ($request->has('modo')?$request->get('modo'):'');
        if($modo=='Excel' or $modo=='PDF'){
            $logs = $this->logs->reporte($desde,$hasta,100);  //vista sin paginar
        }
        $origen = 'logs';
        return $this->exeModo($origen,$modo,$desde,$hasta,$logs);
    }

    private function exeModo($origen,$modo,$desde,$hasta,$info){
        switch($modo){
            case 'PDF':
                $pdf = $this->toPDF('sistema.reportes.pdf.'.$origen,$desde,$hasta,$info);
                return $pdf->stream();
                //break;
            case 'Excel':
                $this->toExcel($origen,'sistema.reportes.pdf.'.$origen,$desde,$hasta,$info);
                return true;
                //break;
            default:
                return view('sistema.reportes.'.$origen,compact('info','desde','hasta'));
                //break;
        }
    }
    private function toExcel($nombre,$vista,$desde,$hasta,$info){
        Excel::create($nombre, function($excel) use($info,$vista,$desde,$hasta) {
            $NombreHoja = $desde.' > '.$hasta;
            //dd($NombreHoja);
            $excel->sheet($NombreHoja, function($sheet) use($info,$vista,$desde,$hasta) {
                $sheet->loadView($vista,compact('info','hasta','desde'));
            });
        })->export('xls');
    }
    private function toPDF($vista,$desde,$hasta,$info){
        $pdf = PDF::loadView($vista,compact('info','hasta','desde'));
        return $pdf;
    }
}
