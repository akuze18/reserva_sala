<?php

namespace App\Http\Controllers;

use App\Piso;
use App\Edificio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class PisoController extends Controller
{
    public function index()
    {
        $pisos = Piso::join('edificios as e','e.id','=','pisos.edificio_id')
            ->select('pisos.*')
            ->orderBy('e.name')
            ->orderby('pisos.name')
            ->paginate(15);
        return view('sistema.piso.list',compact('pisos'));
    }

    public function create()
    {
        $edificios = Edificio::all();
        return view('sistema.piso.create',compact('edificios'));
    }

    public function store(Request $request)
    {
        $reglas = [
            'name'=>['required'],
            'edificio_id'=>['required','integer'],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $edificio = $datos['edificio_id'];
        $regla = [
            'name'=>[Rule::unique('pisos','name')
                ->where(function($query)use($edificio){
                    $query->where('edificio_id',$edificio);
                })],
        ];
        $this->validate($request,$regla);
        $valuesNewPiso = [
            'name' =>$datos['name'],
            'edificio_id'=>$edificio
        ];
        $newPiso = Piso::create($valuesNewPiso);
        new Log('Crear','Piso',ActualUser(),$newPiso->id);
        $mensaje = ['exito'=>'Se creó un nuevo Piso\\n'.$newPiso->name.' \u003E Edificio '.$newPiso->edificio->name];
        return redirect()->route('piso.list')->with($mensaje);
    }

    public function show($id)
    {
        $piso = Piso::where('id',$id)->firstOrFail();
        return view('sistema.piso.show',compact('piso'));
    }

    public function edit($id)
    {
        $piso = Piso::where('id',$id)->firstOrFail();
        $edificios = Edificio::all();
        return view('sistema.piso.edit',compact('edificios','piso'));
    }

    public function update(Request $request, $id)
    {
        $piso = Piso::where('id',$id)->firstOrFail();
        $reglas = [
            'name'=>['required'],
            'edificio_id'=>['required','integer'],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $edificio = $datos['edificio_id'];
        $regla = [
            'name'=>[Rule::unique('pisos','name')
                ->where(function($query)use($edificio){
                    $query->where('edificio_id',$edificio);
                })
                ->ignore($piso->id,'id')],
        ];
        $this->validate($request,$regla);
        $contar = 0;
        if($piso->name!=$datos['name']){
            $piso->name = $datos['name'];
            $contar+=1;
        }
        if($piso->edificio_id!=$edificio){
            $piso->edificio_id = $edificio;
            $contar+=1;
        }
        if($contar>0){
            $piso->save();
            new Log('Modificar','Piso',ActualUser(),$piso->id);
            $mensaje = ['exito'=>'Se modificó el piso\\n'.$piso->name.' \u003E Edificio '.$piso->edificio->name];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningún cambio en el piso\\n'.$piso->name.' \u003E Edificio '.$piso->edificio->name];
        }
        return redirect()->route('piso.list')->with($mensaje);
    }

    public function destroy($id)
    {
        $piso = Piso::where('id',$id)->firstOrFail();
        if($piso->salas()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar el piso ya que tiene salas asignadas \\n'.$piso->name.' \u003E Edificio '.$piso->edificio->name];
        }
        else{
            $piso->delete();
            new Log('Eliminar','Piso',ActualUser(),$piso->id);
            $mensaje = ['exito'=>'Se elimino el piso\\n'.$piso->name.' \u003E Edificio '.$piso->edificio->name];
        }

        return redirect()->route('piso.list')->with($mensaje);
    }
}
