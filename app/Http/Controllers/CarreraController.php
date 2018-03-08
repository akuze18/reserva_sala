<?php

namespace App\Http\Controllers;

use App\Carrera;
use App\nivel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::orderBy('name')->paginate(15);
        return view('sistema.carrera.list',compact('carreras'));
    }

    public function create()
    {
        $semestres = nivel::all();
        return view('sistema.carrera.create',compact('semestres'));
    }

    public function store(Request $request)
    {
        $reglas = [
            'slug'=>[
                'required',
                Rule::unique('carreras','slug')
            ],
            'name'=>[
                'required',
                Rule::unique('carreras','name')
            ],
            'semestres'=>['required','integer']
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();

        $newCarrera = new Carrera();
        $newCarrera->slug = $datos['slug'];
        $newCarrera->name = $datos['name'];
        $newCarrera->semestres = $datos['semestres'];
        $newCarrera->save();

        new Log('Crear','Carrera',ActualUser(),$newCarrera->id);
        $mensaje = ['exito'=>'Se creó una nueva Carrera\\n'.$newCarrera->name];
        return redirect()->route('carrera.list')->with($mensaje);
    }

    public function show($id)
    {
        $carrera = Carrera::where('id',$id)->firstOrFail();
        return view('sistema.carrera.show',compact('carrera'));
    }

    public function edit($id)
    {
        $semestres = nivel::all();
        $carrera = Carrera::where('id',$id)->firstOrFail();
        return view('sistema.carrera.edit',compact('carrera','semestres'));
    }

    public function update(Request $request, $id)
    {
        $carrera = Carrera::where('id',$id)->firstOrFail();
        $reglas = [
            'slug'=>[
                'required',
                Rule::unique('carreras','slug')->ignore($carrera->id,'id')
            ],
            'name'=>[
                'required',
                Rule::unique('carreras','name')->ignore($carrera->id,'id')
            ],
            'semestres'=>['required','integer']
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        $contar = 0;
        if($carrera->slug!=$datos['slug']){
            $carrera->slug = $datos['slug'];
            $contar+=1;
        }
        if($carrera->name!=$datos['name']){
            $carrera->name = $datos['name'];
            $contar+=1;
        }
        if($carrera->semestres!=$datos['semestres']){
            $carrera->semestres = $datos['semestres'];
            $contar+=1;
        }
        if($contar>0){
            $carrera->save();
            new Log('Modificar','Carrera',ActualUser(),$carrera->id);
            $mensaje = ['exito'=>'Se modificó la carrera\\n'.$carrera->name];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningún cambio en la carrera\\n'.$carrera->name];
        }
        return redirect()->route('carrera.list')->with($mensaje);
    }

    public function destroy($id)
    {
        $carrera = Carrera::where('id',$id)->firstOrFail();
        if($carrera->asignaturas()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar la carrera ya que tiene ramos asignados \\n'.$carrera->name];
        }
        else{
            $carrera->delete();
            new Log('Eliminar','Carrera',ActualUser(),$carrera->id);
            $mensaje = ['exito'=>'Se elimino la carrera\\n'.$carrera->name];
        }

        return redirect()->route('carrera.list')->with($mensaje);
    }
}
