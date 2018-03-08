<?php

namespace App\Http\Controllers;

use App\CargaAcademica;
use App\Consultas\Main as Consultas;
use App\Disponibilidad;
use App\Mail\sender;
use App\Motivo;
use App\nivel;
use App\Solicitud;
use App\SolicitudRechazo;
use App\Tomado;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Logs\Main as Log;

class CargaAcademicaController extends Controller
{
    private $docentes,$dias,$horarios,$asignaturas,$modulos,$edificios,$pisos,$salas,$carreras;

    public function __construct(Consultas $consulta){
        $this->docentes = $consulta->docentes();
        $this->dias = $consulta->dias();
        $this->horarios = $consulta->horarios();
        $this->asignaturas = $consulta->asignaturas();
        $this->modulos = $consulta->modulos();
        $this->edificios = $consulta->edificios();
        $this->pisos = $consulta->pisos();
        $this->salas = $consulta->salas();
        $this->carreras = $consulta->carreras();
    }

    public function index()
    {
        $docentes = $this->docentes->pag(15);
        return view('sistema.carga-academica.list',compact('docentes'));
    }
    public function detail($docente_id)
    {
        $docente =$this->docentes->firstFailById($docente_id);
        $carga_docente = $docente->cargas_academicas;
        $dias = $this->dias->getActivos();
        $modulos = $this->modulos->todos();
        $asignacion = [];
        foreach($dias as $dia){
            $asignacion = array_add($asignacion,$dia->id,[]);
            foreach($modulos as $modulo){
                $horario = $this->horarios->byDiaModulo($dia->id,$modulo->id)->first();
                if(is_null($carga_docente)){$value = null;}
                else{
                    $value = $carga_docente->where('horario_id',$horario->id)->first();
                }

                $asignacion[$dia->id] = array_add($asignacion[$dia->id],$modulo->id,[$horario,$value]);
            }
        }
        return view('sistema.carga-academica.detail',compact('docente','dias','modulos','asignacion'));
    }

    public function create(Request $request,$docente_id,$horario_id)
    {
        $docentes = $this->docentes->all();
        $docente = $this->docentes->firstFailById($docente_id);
        $horario = $this->horarios->byId($horario_id)->firstOrFail();
        $dia = $horario->dia;
        $modulo = $horario->modulo;
        $carreras = $this->carreras->allByName();
        if(!is_null($request->old('carrera_id')) or !is_null($docente->carrera->id)){
            if(!is_null($request->old('carrera_id'))){
                $carreraUsar = $request->old('carrera_id');
            }
            else{
                $carreraUsar = $docente->carrera->id;
            }
            $asignaturas = $this->asignaturas->getByCarrera($carreraUsar);
        }
        else{$asignaturas = [];}
        $modulos = $this->modulos->todos();
        $dias = $this->dias->getActivos();

        $edificios = $this->edificios->todos();
        if(!is_null($request->old('edificio_id'))){
            $pisos = $this->pisos->getByEdificio($request->old('edificio_id'));
        }
        else{$pisos = [];}
        //dd($pisos);
        if(!is_null($request->old('piso_id'))){
            $salas = $this->salas->getByPiso($request->old('piso_id'));
        }
        else{$salas = [];}
        return view('sistema.carga-academica.create',
            compact('docentes','carreras','asignaturas','modulos','dias',
                'edificios','pisos','salas',
                'docente','carreraUsar','modulo','dia','horario'));
    }
    public function store(Request $request)
    {
        $reglas = [
            'docente_id'=>['required','integer','exists:users,id'],
            'asignatura_id'=>['required','integer','exists:asignaturas,id'],
            'horario_id'=>['required','integer','exists:horarios,id'],
            'sala_id'=>['required','integer','exists:salas,id'],
        ];
        $this->validate($request,$reglas);
        $horario_id = $request->get('horario_id');
        $asignatura_id = $request->get('asignatura_id');
        $docente_id = $request->get('docente_id');
        $sala_id = $request->get('sala_id');

        //Regla 1: docente no puede tener mas de una carga academica en el mismo horario (modulo + dia)
        $regla1 = ['docente_id'=>
            Rule::unique('carga_academicas','docente_id')
            ->where(function($query)use($horario_id){$query->where('horario_id',$horario_id);})
        ];
        $mensaje1 = ['docente_id.unique'=>'Docente ya tiene una carga academiaca asignada a ese horario'];
        $this->validate($request,$regla1,$mensaje1);
        //Regla 2: la misma disponibilidad no puede estar asignada a otro docente
        //disponibilidad = sala + horario => sala + modulo + dia
        $regla2 = ['sala_id'=>
            Rule::unique('carga_academicas','sala_id')
                ->where(function($query)use($horario_id){$query->where('horario_id',$horario_id);})
        ];
        $mensaje2 = ['sala_id.unique'=>'Sala ya se encuentra utilizada por otro docente en el mismo horario'];
        $this->validate($request,$regla2,$mensaje2);

        //Guardo la Carga académica
        $newCargaAcad = new CargaAcademica;
        $newCargaAcad->fill([
            'docente_id'=>$docente_id,
            'asignatura_id'=>$asignatura_id,
            'horario_id'=>$horario_id,
            'sala_id'=>$sala_id
        ])->save();

        $resultado = $this->actualizar_tomado($newCargaAcad);

        switch($resultado){
            case 0:
                new Log('Crear','CargaAcademica',ActualUser(),$newCargaAcad->id);
                $mensaje = ['exito'=>'Creada nueva carga academica para el docente '.$newCargaAcad->docente->name];
                break;
            case 1:
                $mensaje = ['fallo'=>'No se puede agregar la carga academica, pues otro docente la tiene tomada'];
                break;
            case 2:
                $mensaje = ['fallo'=>'No se puede agregar la carga academica. Se ha producido una inconsistencia en el sistema'];
                break;
            default:
                $mensaje = ['fallo'=>'Error desconocido'];
                break;
        }
        return redirect()->route('CA.detail',$docente_id)->with($mensaje);
    }

    public function edit(Request $request,$ca_id)
    {
        $cargaAcademica = CargaAcademica::where('id',$ca_id)->firstOrFail();
        $docentes = $this->docentes->allByName();
        $docente = $cargaAcademica->docente;
        $horario = $cargaAcademica->horario;

        $dia = $horario->dia;
        $modulo = $horario->modulo;
        $carreras = $this->carreras->allByName();
        if(!is_null($request->old('carrera_id')) or !is_null($docente->carrera->id)){
            if(!is_null($request->old('carrera_id'))){
                $carreraUsar = $request->old('carrera_id');
            }
            else{
                $carreraUsar = $cargaAcademica->asignatura->carrera->id;
            }

            $asignaturas = $this->asignaturas->getByCarrera($carreraUsar);
            //dd($asignaturas);
        }
        else{$asignaturas = [];}
        //obtengo asignatura
        if(!is_null($request->old('asignatura_id'))){$asignatura = $request->old('asignatura_id');}
        else{$asignatura = $cargaAcademica->asignatura->id;}

        $modulos = $this->modulos->todos();
        $dias = $this->dias->getActivos();

        $edificios = $this->edificios->todos();
        if(!is_null($request->old('edificio_id')) or !is_null($cargaAcademica->sala->piso->edificio) ){
            if(!is_null($request->old('edificio_id'))){
                $edificio =$request->old('edificio_id');
            }
            else{
                $edificio = $cargaAcademica->sala->piso->edificio->id;
            }
            $pisos = $this->pisos->getByEdificio($edificio);
        }
        else{$edificio = null;$pisos = [];}
        if(!is_null($request->old('piso_id')) or !is_null($cargaAcademica->sala->piso) ){
            if(!is_null($request->old('piso_id'))){
                $piso = $request->old('piso_id');
            }
            else{
                $piso = $cargaAcademica->sala->piso->id;
            }
            $salas = $this->salas->getByPiso($piso);
        }
        else{$salas = [];$piso=null;}
        if(!is_null($request->old('sala_id')) or !is_null($cargaAcademica->sala)){
            if(!is_null($request->old('sala_id'))){
                $sala = $request->old('sala_id');
            }
            else{
                $sala = $cargaAcademica->sala->id;
            }
        }
        else{$sala=null;}
        return view('sistema.carga-academica.edit',
            compact('docentes','carreras','asignaturas','modulos','dias',
                'edificios','pisos','salas','cargaAcademica',
                'docente','carreraUsar','modulo','dia','horario',
                'asignatura','edificio','piso','sala'));
    }
    public function update(Request $request, $ca_id)
    {
        $cargaAcademica = CargaAcademica::where('id',$ca_id)->firstOrFail();
        $reglas = [
            'docente_id'=>['required','integer','exists:users,id'],
            'asignatura_id'=>['required','integer','exists:asignaturas,id'],
            'horario_id'=>['required','integer','exists:horarios,id'],
            'sala_id'=>['required','integer','exists:salas,id'],
        ];
        $this->validate($request,$reglas);
        $horario_id = $request->get('horario_id');
        $asignatura_id = $request->get('asignatura_id');
        $docente_id = $request->get('docente_id');
        $sala_id = $request->get('sala_id');

        //Regla 1: docente no puede tener mas de una carga academica en el mismo horario (modulo + dia)
        $regla1 = ['docente_id'=>
            Rule::unique('carga_academicas','docente_id')
                ->where(function(Builder $query)use($horario_id){$query->where('horario_id',$horario_id);})
                ->ignore($cargaAcademica->id)
        ];
        $mensaje1 = ['docente_id.unique'=>'Docente ya tiene una carga academica asignada a ese horario'];
        $this->validate($request,$regla1,$mensaje1);
        //Regla 2: la misma disponibilidad no puede estar asignada a otro docente
        //disponibilidad = sala + horario => sala + modulo + dia
        $regla2 = ['sala_id'=>
            Rule::unique('carga_academicas','sala_id')
                ->where(function(Builder $query)use($horario_id){$query->where('horario_id',$horario_id);})
                ->ignore($cargaAcademica->id)
        ];
        $mensaje2 = ['sala_id.unique'=>'Sala ya se encuentra utilizada por otro docente en el mismo horario'];
        $this->validate($request,$regla2,$mensaje2);

        //Modifico la Carga académica
        $contar = 0;
        if($cargaAcademica->docente->id!=$docente_id){
            $cargaAcademica->docente_id=$docente_id;
            $contar++;
        }
        if($cargaAcademica->asignatura->id!=$asignatura_id){
            $cargaAcademica->asignatura_id=$asignatura_id;
            $contar++;
        }
        if($cargaAcademica->horario->id!=$horario_id){
            $cargaAcademica->horario_id=$horario_id;
            $contar++;
        }
        if($cargaAcademica->sala->id!=$sala_id){
            $cargaAcademica->sala_id=$sala_id;
            $contar++;
        }
        if($cargaAcademica->sala->id!=$sala_id or $cargaAcademica->horario->id!=$horario_id){
            //significa que se modificó la disponibilidad y por lo tanto, debemos actualizar el tomado
        }
        if($contar==0){
            $mensaje = ['info'=>'Carga Academica del docente '.$cargaAcademica->docente->name.' no sufrio cambios'];
        }
        else{
            $cargaAcademica->save();
            $resultado = $this->actualizar_tomado($cargaAcademica);
            switch($resultado){
                case 0:
                    new Log('Modificar','CargaAcademica',ActualUser(),$cargaAcademica->id);
                    $mensaje = ['exito'=>'Carga Academica del docente '.$cargaAcademica->docente->name.' fue actualizada'];
                    break;
                case 1:
                    $mensaje = ['fallo'=>'No se puede agregar la carga academica, pues otro docente la tiene tomada'];
                    break;
                case 2:
                    $mensaje = ['fallo'=>'No se puede agregar la carga academica. Se ha producido una inconsistencia en el sistema'];
                    break;
                default:
                    $mensaje = ['fallo'=>'Error desconocido'];
                    break;
            }
        }
        return redirect()->route('CA.detail',$docente_id)->with($mensaje);
    }

    public function destroy($ca_id)
    {
        $cargaAcademica = CargaAcademica::where('id',$ca_id)->firstOrFail();
        //desactivo el tomado de la carga académica y dejo disponible la "disponibilidad" de sala/horario
        foreach($cargaAcademica->tomado as $tomado){
            if($tomado->activo){
                $tomado->disponibilidad->estado = 'Disponible';
                $tomado->disponibilidad->save();
            }
            $tomado->delete();
        }
        $cargaAcademica->delete();
        new Log('Eliminar','CargaAcademica',ActualUser(),$cargaAcademica->id);
        $mensaje = ['exito'=>'Se ha quitado la carga academica del docente '.$cargaAcademica->docente->name];
        return redirect()->route('CA.detail',$cargaAcademica->docente->id)->with($mensaje);
    }

    public function search(Request $request){

        $carreras = $this->carreras->allByName();
        $asignaturas = $this->asignaturas->allByName();
        $modulos = $this->modulos->allByHora();
        $dias = $this->dias->getActivos();
        $niveles = nivel::orderBy('id')->get();
        $docentes = $this->docentes->allByName();
        $datos = $request->all();
        //Proceso datos de busqueda si los hubiera
        if(array_key_exists('carrera',$datos) ){
            if($datos['carrera']!=''){
                $carrera = $datos['carrera'];
                $asignaturas = $asignaturas->where('carrera_id',$carrera);
            }
            else{$carrera = null;}
        }
        else{
            $carrera = null;
        }
        if(array_key_exists('asignatura',$datos) ){
            if($datos['asignatura']!=''){
                $asignatura = $datos['asignatura'];
            }
            else{$asignatura = null;}
        }
        else{
            $asignatura = null;
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
            if($datos['dia']!=''){
                $dia = $datos['dia'];
            }
            else{$dia = null;}
        }
        else{
            $dia = null;
        }
        if(array_key_exists('nivel',$datos) ){
            if($datos['nivel']!=''){
                $nivel = $datos['nivel'];
                $asignaturas = $asignaturas->where('nivel_id',$nivel);
            }
            else{$nivel = null;}
        }
        else{
            $nivel = null;
        }
        if(array_key_exists('docente',$datos) ){
            if($datos['docente']!=''){
                $docente = $datos['docente'];
            }
            else{$docente = null;}
        }
        else{
            $docente = null;
        }

        $cargas_academicas = CargaAcademica::buscar($docente,$carrera,$nivel,$asignatura,$modulo,$dia)->paginate(15);

        return view('sistema.carga-academica.search',compact('cargas_academicas',
            'carreras','asignaturas','modulos','dias','niveles','docentes',
            'carrera','asignatura','modulo','dia','nivel','docente'
        ));
    }

    private function actualizar_tomado(CargaAcademica $newCargaAcad){
        //Reviso si la carga ya estaba tomada
        $tomado = $newCargaAcad->tomado_actual();
        $resultado = 0;
        if(!is_null($tomado)){
            //esta modificando la carga académica entonces desactivo el actual tomado y libero la disponibilidad
            $tomado->activo = false;
            $tomado->save();
            $tomado->disponibilidad->estado = 'Disponible';
            $tomado->disponibilidad->save();
        }

        //Tomo la disponibilidad de correspondiente a la carga
        $disponibilidad = Disponibilidad::where('horario_id',$newCargaAcad->horario_id)
            ->where('sala_id',$newCargaAcad->sala_id)
            ->first();
        if(!is_null($disponibilidad)){
            $disponibilidad->estado = 'Ocupado';
            $tomado = $disponibilidad->tomado_actual();
            if(is_null($tomado)){
                $disponibilidad->save();
                //si no tiene tomado, se lo creamos
                $tomado = new Tomado;
                $tomado->fill([
                    'disponibilidad_id'=>$disponibilidad->id,
                    'tomable_id'=>$newCargaAcad->id,
                    'tomable_type'=>CargaAcademica::class
                ])->save();
            }
            else{
                //ya tiene un tomado hay revisar si es de carga académica o solicitud para priorizar
                if(is_a($tomado->tomable,Solicitud::class)){
                    $disponibilidad->save();
                    //le quito la tomada a la solicitud y se la dejo a la carga académica
                    $tomado->activo = false;
                    $tomado->save();
                    $solicitud = $tomado->tomable;

                    $solicitud->estado = 'Rechazada';
                    $solicitud->save();
                    $motivo = Motivo::where('action','rechazo')
                        ->where('descripcion','Reasignada')
                        ->first();
                    $rechazado = new SolicitudRechazo;
                    $rechazado->fill([
                        'solicitud_id'=>$solicitud->id,
                        'motivo_id'=>$motivo->id
                    ])->save();
                    //todo:enviar correo que se le quito reserva
                    $mail = new sender($solicitud->user);
                    $mail->solicitud_cambio($solicitud);
                    new \App\Logs\Main('Rechazada','Solicitud',actualUser(),$solicitud->id,$motivo);
                    //ahora agrego la nueva tomada de disponibilidad
                    $nuevo_tomado = new Tomado;
                    $nuevo_tomado->fill([
                        'disponibilidad_id'=>$disponibilidad->id,
                        'tomable_id'=>$newCargaAcad->id,
                        'tomable_type'=>CargaAcademica::class
                    ])->save();
                }
                else{
                    if(is_a($tomado->tomable,CargaAcademica::class)){
                        //si otra carga académica tiene tomado, no se lo puedo quitar
                        /*en teoría no debería llegar aqui nunca, ya que se supone que se validó previamente
                        que eso no pasara, pero un nunca sabe*/
                        $newCargaAcad->delete();
                        $resultado=1;
                    }
                    else{
                        //esta tomado por algo que no es carga academica ni solicitud
                        //esto si que es raro y ya es un error grave
                        $newCargaAcad->delete();
                        $resultado=2;
                    }
                }
            }
        }
        else{
            //si la disponibilidad es nula, entonces hay que crearla y tomarla
            $disponibilidad = new Disponibilidad();
            $disponibilidad->fill([
                'horario_id'=>$newCargaAcad->horario_id,
                'sala_id'=>$newCargaAcad->sala_id,
                'estado'=>'Ocupado',
            ])->save();
            $tomado = new Tomado;
            $tomado->fill([
                'disponibilidad_id'=>$disponibilidad->id,
                'tomable_id'=>$newCargaAcad->id,
                'tomable_type'=>CargaAcademica::class
            ])->save();
        }
        return $resultado;
    }
}
