<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 180); //3 minutes
use App\Dia;
use App\Disponibilidad;
use App\Horario;
use App\Modulo;
use App\Edificio;
use App\Sala;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Validation\Rule;

class DisponibilidadController extends Controller
{
    public function index_salas(Request $request)
    {
        $edificios = Edificio::paginate(1, ["*"], "edificio");
        return view('sistema.disponibilidad.list-salas',compact('edificios'));
    }

    public function index_salas2(Request $request,$id_sala)
    {
        $sala = Sala::where('id',$id_sala)->firstOrFail();
        $disponibilidades = Disponibilidad::where('sala_id',$id_sala)->get();
        $modulos = Modulo::all();
        $horarios = Horario::all();
        $dias = Dia::where('activo',true)->orderBy('id')->get();
        return view('sistema.disponibilidad.list-salas2',compact('sala','disponibilidades','modulos','dias','horarios'));
    }

    public function index_horario(Request $request)
    {
        $dias = Dia::where('activo',true)->orderBy('id')->get();
        $modulos = Modulo::all();
        $horarios = Horario::all();
        return view('sistema.disponibilidad.list-horarios',compact('dias','modulos','horarios'));
    }

    public function index_horario2(Request $request,$horario_id)
    {
        $horario = Horario::where('id',$horario_id)->first();
        $disponibilidades = Disponibilidad::where('horario_id',$horario_id)->get();
        $edificios = Edificio::paginate(1, ["*"], "edificio");
        return view('sistema.disponibilidad.list-horarios2',compact('edificios','disponibilidades','horario'));
    }

    public function update(Request $request){
        $busco = [
            'envio'=>Rule::in([
                'single',       //sala-horario
                'sala-modulo','sala-dia','sala','piso','edificio',  //para salas
                'horario-piso','horario-edificio','horario','modulo','dia'   //para horarios
            ]),
            'estado'=>Rule::in(['Deshabilitado','Disponible'])
        ];
        $this->validate($request,$busco);
        $envio = $request->get('envio');
        $estado = $request->get('estado');
        switch($envio){
            case 'single':
                $reglas = [
                    'horario_id'=>['required','integer','exists:horarios,id'],
                    'sala_id'=>['required','integer','exists:salas,id']
                ];
                break;
            case 'sala-modulo':
                $reglas = [
                    'modulo_id'=>['required','integer','exists:modulos,id'],
                    'sala_id'=>['required','integer','exists:salas,id'],
                ];
                break;
            case 'sala-dia':
                $reglas = [
                    'dia_id'=>['required','integer','exists:dias,id'],
                    'sala_id'=>['required','integer','exists:salas,id'],
                ];
                break;
            case 'sala':
                $reglas = [
                    'sala_id'=>['required','integer','exists:salas,id'],
                ];
                break;
            case 'piso':
                $reglas = [
                    'piso_id'=>['required','integer','exists:pisos,id'],
                ];
                break;
            case 'edificio':
                $reglas = [
                    'edificio_id'=>['required','integer','exists:edificios,id'],
                ];
                break;
            case 'horario':
                $reglas = [
                    'horario_id'=>['required','integer','exists:horarios,id'],
                ];
                break;
            case 'modulo':
                $reglas = [
                    'modulo_id'=>['required','integer','exists:modulos,id'],
                ];
                break;
            case 'dia':
                $reglas = [
                    'dia_id'=>['required','integer','exists:dias,id'],
                ];
                break;
            case 'horario-piso':
                $reglas = [
                    'horario_id'=>['required','integer','exists:horarios,id'],
                    'piso_id'=>['required','integer','exists:pisos,id'],
                ];
                break;
            case 'horario-edificio':
                $reglas = [
                    'horario_id'=>['required','integer','exists:horarios,id'],
                    'edificio_id'=>['required','integer','exists:edificios,id'],
                ];
                break;
            default:
                $reglas = ['algo.mas'=>'required'];
                break;
        }
        $this->validate($request,$reglas);
        //Para Extraer Horario
        $horario_id = ($request->has('horario_id')?$request->get('horario_id'):null);
        $modulo_id = ($request->has('modulo_id')?$request->get('modulo_id'):null);
        $dia_id = ($request->has('dia_id')?$request->get('dia_id'):null);
        //Para Extraer Sala
        $sala_id = ($request->has('sala_id')?$request->get('sala_id'):null);
        $piso_id = ($request->has('piso_id')?$request->get('piso_id'):null);
        $edificio_id = ($request->has('edificio_id')?$request->get('edificio_id'):null);

        $horarios = Horario::extraer($horario_id,$modulo_id,$dia_id)->get();
        $salas = Sala::extraer($sala_id,$piso_id,$edificio_id)->get();
        $mSingle = '';
        $mSalaModulo = '';
        $mSalaDia = '';
        $mSala ='';
        $mPiso = '';
        $mEdificio='';
        $mDia = '';
        $mModulo='';
        $mHorario='';
        $mHorarioPiso='';
        $mHorarioEdificio = '';
        foreach($salas as $sala){
            foreach($horarios as $horario){
                $disponibilidad = Disponibilidad::where('sala_id',$sala->id)->where('horario_id',$horario->id)->first();
                if(is_null($disponibilidad)){
                    $disponibilidad = new Disponibilidad();
                    $disponibilidad->fill([
                        'sala_id'=>$sala->id,
                        'horario_id'=>$horario->id,
                        'estado'=>$estado
                    ])->save();
                }
                else{
                    if(is_null($disponibilidad->tomado_actual())){
                        $disponibilidad->estado = $estado;
                        $disponibilidad->save();
                    }
                }
                $mSingle = 'Sala '.$sala->name.' en '.$horario->display.'\n'.'Se encuentra '.$estado;
                $mSalaModulo = 'Modulo '.$horario->modulo->full_name.' en la sala '.$sala->name.' esta '.$estado.' todos los dias';
                $mSalaDia = 'Dia '.$horario->dia->name.' en la sala '.$sala->name.' esta '.$estado.' en todos los modulos';
                $mDia = 'Dia '.$horario->dia->name.' esta '.$estado.' en todos los modulos y en todas las salas';
                $mModulo = 'Modulo '.$horario->modulo->full_name.' esta '.$estado.' para todos los dias y en todas las salas';
                $mHorario = ''.$horario->display.' esta '.$estado.' en todas las salas';
                $mHorarioPiso = ''.$horario->display.' esta '.$estado.' en todo el Piso '.$sala->piso->long_name;
                $mHorarioEdificio = ''.$horario->display.' esta '.$estado.' en todo el Edificio '.$sala->piso->edificio->name;
            }
            $mSala = 'Sala '.$sala->name.' esta '.$estado.' en todo horario';
            $mPiso = 'Piso '.$sala->piso->name.' esta '.$estado.' en todo horario';
            $mEdificio = 'Edificio '.$sala->piso->edificio->name.' esta '.$estado.' en todo horario';

        }
        switch($envio){
            case 'single':  //sala-horario
                $mensaje = ['exito'=>$mSingle];
                break;
            case 'sala-modulo':
                $mensaje = ['exito'=>$mSalaModulo];
                break;
            case 'sala-dia':
                $mensaje = ['exito'=>$mSalaDia];
                break;
            case 'sala':
                $mensaje = ['exito'=>$mSala];
                break;
            case 'piso':
                $mensaje = ['exito'=>$mPiso];
                break;
            case 'edificio':
                $mensaje = ['exito'=>$mEdificio];
                break;
            case 'horario-piso':
                $mensaje = ['exito'=>$mHorarioPiso];
                break;
            case 'horario-edificio':
                $mensaje = ['exito'=>$mHorarioEdificio];
                break;
            case 'horario':
                $mensaje = ['exito'=>$mHorario];
                break;
            case 'modulo':
                $mensaje = ['exito'=>$mModulo];
                break;
            case 'dia':
                $mensaje = ['exito'=>$mDia];
                break;
            default:
                $mensaje = ['info'=>'default'];
                break;
        }
        return redirect()->to($request->session()->previousUrl())->with($mensaje);
    }

}
