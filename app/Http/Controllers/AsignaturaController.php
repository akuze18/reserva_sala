<?php

namespace App\Http\Controllers;

use App\Asignatura;
use App\Carrera;
use App\nivel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Logs\Main as Log;

class AsignaturaController extends Controller
{
    public function index($carrera_id)
    {
        $carrera = Carrera::where('id',$carrera_id)->firstOrFail();
        $asignaturas = Asignatura::where('carrera_id',$carrera_id)->orderBy('nivel_id')->orderBy('name')->paginate(15);
        return view('sistema.asignatura.list',compact('carrera','asignaturas'));
    }

    public function create($carrera_id)
    {
        $carrera = Carrera::where('id',$carrera_id)->firstOrFail();
        $carreras = Carrera::all();
        $niveles = nivel::where('id','<=',$carrera->semestres)->orderBy('id')->get();
        return view('sistema.asignatura.create',compact('carrera','carreras','niveles'));
    }

    public function store(Request $request,$carrera_id)
    {
        $reglas = [
            'slug'=>[
                'required',
                Rule::unique('asignaturas','slug')
            ],
            'name'=>[
                'required',
                Rule::unique('asignaturas','name')->where(function ($query)use($carrera_id){
                    $query->where('carrera_id',$carrera_id);
                })
            ],
            'nivel'=>['required','integer','exists:nivels,id']
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();

        $newAsignatura = new Asignatura();
        $newAsignatura->slug = $datos['slug'];
        $newAsignatura->name = $datos['name'];
        $newAsignatura->nivel()->associate($datos['nivel']);
        $newAsignatura->carrera()->associate($carrera_id);
        $newAsignatura->save();

        new Log('Crear','Asignatura',ActualUser(),$newAsignatura->id);
        $mensaje = ['exito'=>'Se creó una nuevo Ramo\\n'.$newAsignatura->name];
        return redirect()->route('asignatura.list',$carrera_id)->with($mensaje);
    }

    public function show($id)
    {
        $asignatura = Asignatura::where('id',$id)->firstOrFail();
        return view('sistema.asignatura.show',compact('asignatura'));
    }

    public function edit($id)
    {
        $asignatura = Asignatura::where('id',$id)->firstOrFail();
        $carreras = Carrera::all();
        $niveles = nivel::where('id','<=',$asignatura->carrera->semestres)->orderBy('id')->get();

        return view('sistema.asignatura.edit',compact('asignatura','niveles','carreras'));
    }


    public function update(Request $request, $id)
    {
        $asignatura = Asignatura::where('id',$id)->firstOrFail();
        $reglas = [
            'slug'=>[
                'required',
                Rule::unique('asignaturas','slug')->ignore($asignatura->id,'id')
            ],
            'name'=>[
                'required',
                Rule::unique('asignaturas','name')->where(function ($query)use($asignatura){
                    $query->where('carrera_id',$asignatura->carrera->id);
                })->ignore($asignatura->id,'id')
            ],
            'nivel'=>[
                'required',
                'integer',
                Rule::exists('nivels','id')->where(function($query)use($asignatura){
                    $query->where('id','<=',$asignatura->carrera->semestres);
                })
            ]
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();

        $contar = 0;
        if($asignatura->slug!=$datos['slug']){
            $asignatura->slug = $datos['slug'];
            $contar+=1;
        }
        if($asignatura->name!=$datos['name']){
            $asignatura->name = $datos['name'];
            $contar+=1;
        }
        if($asignatura->nivel->id!=$datos['nivel']){
            $asignatura->nivel()->associate($datos['nivel']);
            $contar+=1;
        }
        if($contar>0){
            $asignatura->save();
            new Log('Modificar','Asignatura',ActualUser(),$asignatura->id);
            $mensaje = ['exito'=>'Se modificó la carrera\\n'.$asignatura->name];
        }
        else{
            $mensaje = ['info'=>'No se realizó ningún cambio en la carrera\\n'.$asignatura->name];
        }
        return redirect()->route('asignatura.list',$asignatura->carrera->id)->with($mensaje);
    }

    public function destroy($id)
    {
        $asignatura = Asignatura::where('id',$id)->firstOrFail();
        if($asignatura->cargas_academicas()->count()>0){
            $mensaje = ['fallo'=>'No se eliminar el ramo ya que esta asociado a una carga academica \\n'.$asignatura->name];
        }
        else{
            $asignatura->delete();
            new Log('Eliminar','Asignatura',ActualUser(),$asignatura->id);
            $mensaje = ['exito'=>'Se elimino el ramo\\n'.$asignatura->name];
        }

        return redirect()->route('asignatura.list',$asignatura->carrera->id)->with($mensaje);
    }
}
