<?php

namespace App\Http\Controllers;

use App\Sala;
use Illuminate\Http\Request;
use App\Piso;
use App\Edificio;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class SalaController extends Controller
{
    public function index()
    {
        $salas = Sala::join('pisos as p','p.id','=','salas.piso_id')
            ->join('edificios as e','e.id','=','p.edificio_id')
            ->select('salas.*')
            ->orderBy('e.name')
            ->orderBy('p.name')
            ->orderby('salas.name')
            ->paginate(15);
        return view('sistema.sala.list',compact('salas'));
    }

    public function create(Request $request)
    {
        $edificios = Edificio::all();
        if(is_null($request->old('edificio_id'))){
            $pisos = [];
        }
        else{
            $edificio_id = $request->old('edificio_id');
            $pisos = Piso::where('edificio_id',$edificio_id)->get();
        }
        return view('sistema.sala.create',compact('edificios','pisos'));
    }

    public function store(Request $request)
    {
        $reglas = [
            'name'=>['required'],
            'capacidad'=>['required','integer'],
            'edificio_id'=>['required','integer'],
            'piso_id'=>['required','integer'],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $piso = $datos['piso_id'];
        $regla = [
            'name'=>[Rule::unique('salas','name')
                ->where(function($query)use($piso){
                    $query->where('piso_id',$piso);
            })],
        ];
        $this->validate($request,$regla);
        $valuesNewSala = [
            'name' =>$datos['name'],
            'capacidad'=>$datos['capacidad'],
            'piso_id'=>$piso
        ];
        $newSala = Sala::create($valuesNewSala);
        new Log('Crear','Sala',ActualUser(),$newSala->id);
        $mensaje = ['exito'=>'Se creó una nueva sala\\n'.$newSala->name.' \u003E Piso '.$newSala->piso->name.' \u003E Edificio '.$newSala->piso->edificio->name];
        return redirect()->route('sala.list')->with($mensaje);
    }

    public function show($sala_id)
    {
        $sala = Sala::where('id',$sala_id)->firstOrFail();
        return view('sistema.sala.show',compact('sala'));
    }

    public function edit(Request $request,$id)
    {
        $sala = Sala::where('id',$id)->firstOrFail();
        $edificios = Edificio::all();
        if(is_null($request->old('edificio_id'))){
            $pisos = Piso::where('edificio_id',$sala->piso->edificio->id)->get();
        }
        else{
            $edificio_id = $request->old('edificio_id');
            $pisos = Piso::where('edificio_id',$edificio_id)->get();
        }
        return view('sistema.sala.edit',compact('edificios','pisos','sala'));
    }

    public function update(Request $request, $id)
    {
        $sala = Sala::where('id',$id)->firstOrFail();
        $reglas = [
            'name'=>['required'],
            'capacidad'=>['required','integer'],
            'edificio_id'=>['required','integer'],
            'piso_id'=>['required','integer'],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $piso = $datos['piso_id'];
        $regla = [
            'name'=>[Rule::unique('salas','name')
                ->where(function($query)use($piso){
                    $query->where('piso_id',$piso);
                })
                ->ignore($sala->id,'id')],
        ];
        $this->validate($request,$regla);
        $contar = 0;
        if($sala->name!=$datos['name']){
            $sala->name = $datos['name'];
            $contar+=1;
        }
        if($sala->capacidad!=$datos['capacidad']){
            $sala->capacidad = $datos['capacidad'];
            $contar+=1;
        }
        if($sala->piso_id!=$piso){
            $sala->piso_id = $piso;
            $contar+=1;
        }
        if($contar>0){
            $sala->save();
            new Log('Modificar','Sala',ActualUser(),$sala->id);
            $mensaje = ['exito'=>'Se modificó la sala\\n'.$sala->name.' \u003E Piso '.$sala->piso->name.' \u003E Edificio '.$sala->piso->edificio->name];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningún cambio en la sala\\n'.$sala->name.' \u003E Piso '.$sala->piso->name.' \u003E Edificio '.$sala->piso->edificio->name];
        }
        return redirect()->route('sala.list')->with($mensaje);
    }

    public function destroy($id)
    {
        $sala = Sala::where('id',$id)->firstOrFail();
        if($sala->disponibles()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar la sala ya que esta disponible o en uso\\n'.$sala->name.' \u003E Piso '.$sala->piso->name.' \u003E Edificio '.$sala->piso->edificio->name];
        }
        else{
            $sala->delete();
            new Log('Eliminar','Sala',ActualUser(),$sala->id);
            $mensaje = ['exito'=>'Se elimino la sala\\n'.$sala->name.' \u003E Piso '.$sala->piso->name.' \u003E Edificio '.$sala->piso->edificio->name];
        }

        return redirect()->route('sala.list')->with($mensaje);
    }

}
