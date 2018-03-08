<?php

namespace App\Http\Controllers;

use App\Edificio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class EdificioController extends Controller
{
    public function index()
    {
        $edificios = Edificio::orderBy('name')->paginate(15);
        return view('sistema.edificio.list',compact('edificios'));
    }

    public function create()
    {
        return view('sistema.edificio.create');
    }

    public function store(Request $request)
    {
        $reglas = [
            'name'=>[
                'required',
                Rule::unique('edificios','name')
            ]
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();

        $valuesNewEdificio = [
            'name' =>$datos['name']
        ];
        $newEdificio = Edificio::create($valuesNewEdificio);
        new Log('Crear','Edificio',ActualUser(),$newEdificio->id);
        $mensaje = ['exito'=>'Se creó un nuevo Edificio\\n'.$newEdificio->name];
        return redirect()->route('edificio.list')->with($mensaje);
    }

    public function show($id)
    {
        $edificio = Edificio::where('id',$id)->firstOrFail();
        return view('sistema.edificio.show',compact('edificio'));
    }

    public function edit($id)
    {
        $edificio = Edificio::where('id',$id)->firstOrFail();
        return view('sistema.edificio.edit',compact('edificio'));
    }

    public function update(Request $request, $id)
    {
        $edificio = Edificio::where('id',$id)->firstOrFail();
        $reglas = [
            'name'=>[
                'required',
                Rule::unique('edificios','name')->ignore($edificio->id,'id')
            ],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $contar = 0;
        if($edificio->name!=$datos['name']){
            $edificio->name = $datos['name'];
            $contar+=1;
        }
        if($contar>0){
            $edificio->save();
            new Log('Modificar','Edificio',ActualUser(),$edificio->id);
            $mensaje = ['exito'=>'Se modificó el edificio\\n'.$edificio->name];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningún cambio en el edificio\\n'.$edificio->name];
        }
        return redirect()->route('edificio.list')->with($mensaje);
    }

    public function destroy($id)
    {
        $edificio = Edificio::where('id',$id)->firstOrFail();
        if($edificio->pisos()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar el edificio ya que tiene pisos asignados \\n'.$edificio->name];
        }
        else{
            $edificio->delete();
            new Log('Eliminar','Edificio',ActualUser(),$edificio->id);
            $mensaje = ['exito'=>'Se elimino el edificio\\n'.$edificio->name];
        }

        return redirect()->route('edificio.list')->with($mensaje);
    }
}
