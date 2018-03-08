<?php

namespace App\Http\Controllers;

use App\motivo;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MotivoController extends Controller
{
    public function index()
    {
        $motivos = Motivo::orderBy('action')->paginate(15);
        return view('sistema.motivo.list',compact('motivos'));
    }

    public function create()
    {
        $acciones = DB::table('motivos')
            ->select('action as id','action as fullname')
            ->groupBy('action')
            ->orderBy('action')
            ->get();
        //dd($acciones);
        return view('sistema.motivo.create',compact('acciones'));
    }

    public function store(Request $request)
    {
        $reglas = [
            'accion'=>['required','max:30'],
            'descripcion'=>['required','max:250'],
        ];
        $this->validate($request,$reglas);
        $accion = $request->get('accion');
        $descripcion = $request->get('descripcion');
        //dd($accion);
        $regla = [
            'descripcion'=>[Rule::unique('motivos','descripcion')
                ->where(function($query)use($accion){
                    $query->where('action',$accion);
                })],
        ];
        $this->validate($request,$regla);
        $newMotivo = Motivo::create([
            'descripcion'=>$descripcion,
            'action'=>$accion,
        ]);
        $mensaje = ['exito'=>'Se creó un nuevo motivo\\n'.$newMotivo->descripcion.' para '.$newMotivo->action];
        return redirect()->route('motivo.list')->with($mensaje);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\motivo  $motivo
     * @return \Illuminate\Http\Response
     */
    public function show(motivo $motivo)
    {
        //
    }

    public function edit($id)
    {
        $motivo = Motivo::where('id',$id)->firstOrFail();
        $acciones = DB::table('motivos')
            ->select('action as id','action as fullname')
            ->groupBy('action')
            ->orderBy('action')
            ->get();
        return view('sistema.motivo.edit',compact('motivo','acciones'));
    }

    public function update(Request $request,$id)
    {
        $motivo = Motivo::where('id',$id)->firstOrFail();
        $reglas = [
            'accion'=>['required','max:30'],
            'descripcion'=>['required','max:250'],
        ];
        $this->validate($request,$reglas);
        $accion = $request->get('accion');
        $descripcion = $request->get('descripcion');
        $regla = [
            'descripcion'=>[Rule::unique('motivos','descripcion')
                ->where(function($query)use($accion){
                    $query->where('action',$accion);
                })->ignore($motivo->id,'id')],
        ];
        $this->validate($request,$regla);

        $contar = 0;
        if($accion!=$motivo->action){
            $motivo->action = $accion;
            $contar++;
        }
        if($descripcion!=$motivo->descripcion){
            $motivo->descripcion = $descripcion;
            $contar++;
        }
        if($contar>0){
            $motivo->save();
            $mensaje = ['exito'=>'Se modificó el motivo a\\n'.$motivo->descripcion.' para '.$motivo->action];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningun cambio en el motivo\\n'.$motivo->descripcion.' para '.$motivo->action];
        }

        return redirect()->route('motivo.list')->with($mensaje);
    }

    public function destroy($id)
    {
        $motivo = Motivo::where('id',$id)->firstOrFail();
        if($motivo->solicitudes()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar el motivo ya que esta en uso\\n'.
                $motivo->descripcion.' \u003E '.$motivo->action];
        }
        else{
            $motivo->delete();
            $mensaje = ['exito'=>'Se elimino el motivo\\n'.
                $motivo->descripcion.' \u003E '.$motivo->action];
        }

        return redirect()->route('motivo.list')->with($mensaje);
    }
}
