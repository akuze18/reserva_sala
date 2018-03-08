<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ultraware\Roles\Models\Permission;
use Ultraware\Roles\Models\Role;
use App\Logs\Main as Log;

class PerfilController extends Controller
{
    public function index(){
        $roles = Role::paginate(10);
        return view('sistema.perfil.list',compact('roles'));
    }

    public function create(){
        $permisos = Permission::orderBy('model')->get();
        return view('sistema.perfil.create',compact('permisos'));
    }

    public function store(Request $request){
        $reglas = [
            'slug'=>['required','max:30','unique:roles,slug','alpha'],
            'name'=>['required','max:100','alpha'],
            'description'=>['present','max:200']
        ];
        $this->validate($request,$reglas);
        $data = $request->all();
        //crear nuevo perfil
        $newRole = new Role();
        $newRole->fill([
            'slug'=>$data['slug'],
            'name'=>$data['name'],
            'description'=>$data['description']
        ])->save();

        $markPermision = array_where($data, function ($value,$key) {
            $identificador = 'permissions';
            return  substr($key,0,strlen($identificador))==$identificador;
        });
        $allPermissions = Permission::all();
        foreach($allPermissions as $onePermission){
            $find = false;
            foreach($markPermision as $idPerm){
                if($onePermission->id==$idPerm){

                    $find = true;
                }
            }
            if($find){
                $newRole->attachPermission($onePermission);
            }else{
                $newRole->detachPermission($onePermission);
            }
        }
        new Log('Crear','Perfil',ActualUser(),$newRole->id);
        $mensaje = ['exito'=>'Se ha creado el perfil '.$newRole->slug];
        return redirect()->route('perfiles.list')->with($mensaje);
    }

    public function show($role_slug){
        $perfil = Role::where('slug',$role_slug)->firstOrFail();
        $permisos = $perfil->permissions->sortBy('model');
        return view('sistema.perfil.show',compact('perfil','permisos'));
    }

    public function edit($role_slug){
        $perfil = Role::where('slug',$role_slug)->firstOrFail();
        $permisos = Permission::orderBy('model')->get();
        return view('sistema.perfil.edit',compact('perfil','permisos'));
    }

    public function update(Request $request,$role_slug){
        $role = Role::where('slug',$role_slug)->firstOrFail();
        $reglas = [
            'name'=>['required','max:100','alpha'],
            'description'=>['present','max:200']
        ];
        $this->validate($request,$reglas);
        $data = $request->all();
        //actualizo info de rol
        $contar = 0;
        if($role->name!=$data['name']){
            $role->name=$data['name'];
            $contar++;
        }
        if($role->description!=$data['description']){
            $role->description=$data['description'];
            $contar++;
        }

        //dd($data);
        $markPermision = array_where($data, function ($value,$key) {
            //dd($value);
            return substr($key,0,strlen('permissions'))=='permissions';
        });

        //dd($markPermision);
        $allPermissions = Permission::all();
        foreach($allPermissions as $onePermission){
            $find = false;
            foreach($markPermision as $idPerm){
                if($onePermission->id==$idPerm){
                    $find = true;
                }
            }

            if($find){
                if($role->permissions->where('id',$onePermission->id)->count()==0){
                    $role->attachPermission($onePermission);
                    $contar++;
                }
            }else{
                if($role->permissions->where('id',$onePermission->id)->count()>0){
                    $role->detachPermission($onePermission);
                    $contar++;
                }

            }
        }
        if($contar>0){
            $role->save();
            new Log('Modificar','Perfil',ActualUser(),$role->id);
            $mensaje = ['exito'=>'Se realizaron correctamente cambios en el perfil '.$role->slug];
        }else{
            $mensaje = ['info'=>'No se realizaron cambios en el perfil'];
        }
        return redirect()->route('perfiles.list')->with($mensaje);
    }
}
