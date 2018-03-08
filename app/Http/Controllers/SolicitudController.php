<?php

namespace App\Http\Controllers;

use App\Consultas\Main as Consultas;
use App\Dia;
use App\Disponibilidad;
use App\Edificio;
use App\Mail\sender;
use App\Modulo;
use App\Motivo;
use App\Piso;
use App\Sala;
use App\Solicitud;
use App\SolicitudRechazo;
use App\Tomado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class SolicitudController extends Controller
{
    private $disp;
    public function __construct(Consultas $consultas){
        $this->disp = $consultas->disponibilidades();
    }

    public function index($estado=null)
    {
        $solicitudes = Solicitud::estado($estado)->paginate(20);
        if(is_null($estado)){$estado='';}
        $motivos = Motivo::where('action','rechazo')->get();
        return view('sistema.solicitud.list',compact('solicitudes','estado','motivos'));
    }

    public function sala_find(Request $request)
    {


        //dd($capacidades);
        $datos = $request->all();
        //Proceso datos de busqueda si los hubiera
        if(array_key_exists('edificio',$datos) ){
            if($datos['edificio']!=''){
                $edificio = Edificio::where('id',$datos['edificio'])->first();
                $edificio_id = $edificio->id;
            }
            else{$edificio_id = null;}
        }
        else{
            $edificio_id = null;
        }
        if(array_key_exists('piso',$datos)){
            if($datos['piso']!=''){
                $piso_id = Piso::where('id',$datos['piso'])->first()->id;
            }
            else{$piso_id = null;}
        }
        else{
            $piso_id = null;
        }
        if(array_key_exists('capacidad',$datos) ){
            if($datos['capacidad']!=''){
                $capacidad = $datos['capacidad'];
            }
            else{$capacidad = null;}
        }
        else{
            $capacidad = null;
        }
        if(array_key_exists('modulo',$datos) ){
            if($datos['modulo']!=''){
                $modulo = $datos['modulo'];
            }
            else{$modulo = null;}
        }
        else{
            $modulo = null;
        }

        if(array_key_exists('dia',$datos) ){
            if($datos['dia']!=''){$dia = $datos['dia'];}
            else{$dia = null;}
        }
        else{
            $dia = null;
        }

        //ejecuto query con resultados de la busqueda
        if(actualUser()->perfil=='docente'){
            $docente=true;
        }
        else{
            $docente=false;
        }
        $disponiblidades = Disponibilidad::buscar($edificio_id,$piso_id,$capacidad,$modulo,$dia,null,$docente)
            ->orderBy('horario_id')->paginate(20);

        $filtro = Disponibilidad::buscar($edificio_id,$piso_id,$capacidad,$modulo,$dia,null,$docente)
            ->join('salas','salas.id','=','sala_id')
            ->join('pisos','pisos.id','=','salas.piso_id')
            ->join('horarios','horarios.id','=','horario_id');
        //Datos para Combos de Busqueda
        //dd($filtro);
        //Ahora los filtros dependerán de las disponibilidades encontradas
        $edificios_disponibles = $filtro->select('pisos.edificio_id')->distinct()->get()->toArray();
        $edificios = Edificio::whereIn('id',$edificios_disponibles)->orderBy('name')->get();
        $pisos_disponibles = $filtro->select('salas.piso_id')->distinct()->get()->toArray();
        $pisos = DB::table('pisos')->select(DB::raw('name as id, name as fullname'))->distinct()
            ->whereIn('id',$pisos_disponibles)->orderBy('name')->get();
        $salas_disponibles = $filtro->select('sala_id')->distinct()->get()->toArray();
        $capacidades = Sala::select(DB::raw('capacidad as id, capacidad as name'))->whereIn('id',$salas_disponibles)->distinct()->orderBy('capacidad')->get();
        $modulos_disponibles = $filtro->select('horarios.modulo_id')->distinct()->get()->toArray();
        $modulos = Modulo::whereIn('id',$modulos_disponibles)->orderBy('hora_inicio')->get();
        $dias_disponibles = $filtro->select('horarios.dia_id')->distinct()->get()->toArray();
        $dias = Dia::where('activo',true)->whereIn('id',$dias_disponibles)->orderBy('id')->get();

        //$disponiblidades = $disponiblidades->paginate();
        $motivos = Motivo::where('action','creacion')->get();

        return view('sistema.solicitud.sala-find',compact(
            'piso_id','edificio_id','capacidad','modulo','dia', //'hora_ini','hora_fin','fecha',
            'edificios','pisos','capacidades','modulos','dias'
            ,'disponiblidades','motivos'
        ));
    }

    public function sala_pedir(Request $request)
    {
        $reglas = [
            'disponible_id'=>['required','integer'],
            'motivo'=>['required','integer','exists:motivos,id']
        ];
        $this->validate($request,$reglas);

        $disponible_id = $request->get('disponible_id');
        $motivo = $request->get('motivo');
        $disponibilidad = $this->disp->getById($disponible_id);
        //reviso si la disponibilidad estaba tomada
        if(!is_null($disponibilidad->tomado_actual())){
            $tomadoOld = $disponibilidad->tomado_actual();
            //si está tomado se lo quito
            if($tomadoOld->tomable instanceof \App\Solicitud){
                $solicitudOld = $tomadoOld->tomable;
                $accion = 'Rechazada';
                $solicitudOld->estado = $accion;
                $solicitudOld->save();
                $motivo_rechazo = Motivo::where('action','rechazo')->where('descripcion','Reasignada')->first();
                $solicitudRechazo = new SolicitudRechazo();
                $solicitudRechazo->motivo()->associate($motivo_rechazo);
                $solicitudRechazo->solicitud()->associate($solicitudOld);
                $solicitudRechazo->save();
                //Renuevo la variable de solicitud
                $solicitudSend = Solicitud::where('id',$solicitudOld->id)->first();
                //registro en el sistema que se cambio la solicitud

                new Log($accion,'Solicitud',ActualUser(),$solicitudSend->id,$motivo_rechazo);
                //y le notifico al usuario que ha perdido su reserva
                $correo = new sender($solicitudSend->user);
                $correo->solicitud_cambio($solicitudSend);

                $tomadoOld->activo = false;
                $tomadoOld->save();
            }
            else{
                return redirect()->to($request->session()->previousUrl());
            }
        }
        $disponibilidad->estado = 'Pendiente';
        $disponibilidad->save();
        $newSolicitud = new Solicitud;
        $newSolicitud->fill([
            'estado'=>'Pendiente',
            'motivo_id'=>$motivo,
            'sala_id'=>$disponibilidad->sala->id,
            'user_id'=>ActualUser()->id,
            'horario_id'=>$disponibilidad->horario->id
        ])->save();
        $tomado = new Tomado;
        $tomado->fill([
            'disponibilidad_id'=>$disponibilidad->id,
            'tomable_id'=>$newSolicitud->id,
            'tomable_type'=>Solicitud::class
        ])->save();
        $mensaje =['exito'=>'Se reservó una sala correctamente, el numero de su solicitud es: '.$newSolicitud->id];
        //dd(compact('mensaje'));
        return redirect()->route('miSolicitud.index')->with($mensaje);
    }

    public function procesar(Request $request){
        $reglas = [
            'accion'=>['required',Rule::in(['Aceptada','Rechazada'])],
            'solicitud_id'=>['required','exists:solicitudes,id']
        ];
        $this->validate($request,$reglas);
        $data = $request->all();
        $accion = $data['accion'];
        $solicitud_id = $data['solicitud_id'];
        $motivo = null;
        if($accion=='Rechazada'){
            //si es rechazo, debo validar el motivo
            $reglas = ['motivo'=>['required','integer','exists:motivos,id']];
            $this->validate($request,$reglas);
            $motivo = $data['motivo'];
        }
        $solicitud = Solicitud::where('id',$solicitud_id)->first();
        $solicitud->estado = $accion;
        $solicitud->save();
        if($accion=='Rechazada') {
            if (is_null($solicitud->rechazo)) {
                //no hay registro previo de rechazo, lo creo
                $newRechazo = new SolicitudRechazo;
                $newRechazo->motivo()->associate($motivo);
                $newRechazo->solicitud()->associate($solicitud);
                $newRechazo->save();
            }
            else{
                //si existe lo modifico (no debería estar aquí, pero mejor prevenir)
                $oldRechazo = $solicitud->rechazo;
                $oldRechazo->motivo_id = $motivo;
                $oldRechazo->save();
            }
            //le quito la tomada de disponibilidad
            $tomado =  $solicitud->tomado->first();
            //dd($tomado);
            $tomado->activo = false;
            $tomado->save();
        }
        switch ($accion){
            case 'Aceptada':
                $accion2 = 'Ocupado';
                break;
            case 'Rechazada':
                $accion2 = 'Disponible';
                break;
            default:
                $accion2 = '';
                break;
        }

        $disponibilidad = Disponibilidad::where('horario_id',$solicitud->horario->id)
            ->where('sala_id',$solicitud->sala->id)->first();
        $disponibilidad->estado = $accion2;
        $disponibilidad->save();

        //refresco mi variable solicitud, para que incorpore los cambios en las tablas relacioandas
        $solicitud =  Solicitud::where('id',$solicitud_id)->first();
        new Log($accion,'Solicitud',ActualUser(),$solicitud->id,$motivo);
        $mail = new sender($solicitud->user);
        $mail->solicitud_cambio($solicitud);

        return redirect()->route('solicitud.index');
    }

}
