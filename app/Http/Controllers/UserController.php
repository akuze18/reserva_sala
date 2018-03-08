<?php

namespace App\Http\Controllers;

use App\CargaAcademica;
use App\Carrera;
use App\Solicitud;
use App\Tomado;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Ultraware\Roles\Models\Role;
use App\Logs\Main as Log;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('perfil')){
            $perfil = $request->get('perfil');
            $regla = ['perfil'=>['required','exists:roles,slug']];
            $this->validate($request,$regla);
        }
        else{
            $perfil = '';
        }
        $roles = Role::all();
        $usuarios = User::BuscarPerfil($perfil)->orderBy('first_name')->orderBy('last_name')->paginate(10);
        return view('sistema.usuario.list',compact('usuarios','roles','perfil'));
    }

    public function index_inactive()
    {
        $usuarios = User::onlyTrashed()->orderBy('first_name')->orderBy('last_name')->paginate(10);
        return view('sistema.usuario.list-inactive',compact('usuarios'));
    }

    public function create()
    {
        $carreras = Carrera::all();
        $roles = Role::all();
        return view('sistema.usuario.create',compact('carreras','roles'));
    }

    public function store(Request $request)
    {
        $reglas = [
            'rut'=>['required'],
            'first_name'=>['required'],
            'last_name'=>['required'],
            'email'=>['required','email','unique:users,email'],
            'perfil'=>['required','integer','exists:roles,id'],
            'carrera'=>['required','integer','exists:carreras,id'],
        ];
        $this->validate($request,$reglas);
        $datos = $request->all();
        //obtengo Rol para perfil
        $rol = Role::where('id',$datos['perfil'])->first();
        //crear nuevo usuario
        $newUser = new User();
        $newUser->fill([
            'rut' => $datos['rut'],
            'first_name' => $datos['first_name'],
            'last_name'=> $datos['last_name'],
            'email' => $datos['email'],
            'password' => bcrypt('123456'),
            'perfil' => $rol->slug
        ]);
        $newUser->carrera()->associate($datos['carrera']);
        $newUser->save();
        $newUser->attachRole($rol);
        new Log('Crear','Usuario',ActualUser(),$newUser->id);
        $mensaje = ['exito'=>'Se ha creado el usuario '.$newUser->name.' correctamente'];
        return redirect()->route('usuario.list')->with($mensaje);
    }

    public function show($id)
    {
        $usuario = User::where('id',$id)->firstOrFail();
        return view('sistema.usuario.show',compact('usuario'));
    }

    public function edit($id)
    {
        $user = User::where('id',$id)->firstOrFail();
        $carreras = Carrera::all();
        $roles = Role::all();
        return view('sistema.usuario.edit',compact('carreras','roles','user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::Where('id',$id)->firstOrFail();
        if(!$request->has('password')){
            //esta modificando el resto de la información, menos la contraseña
            $reglas = [
                'rut'=>['required'],
                'first_name'=>['required'],
                'last_name'=>['required'],
                'email'=>['required','email',Rule::unique('users','email')->ignore($user->id)],
                'perfil'=>['required','integer','exists:roles,id'],
                'carrera'=>['required','integer','exists:carreras,id'],
            ];
            $this->validate($request,$reglas);
            $datos = $request->all();
            //obtengo Rol para perfil
            $rol = Role::where('id',$datos['perfil'])->first();
            $cambios = 0;
            if($user->rut!=$datos['rut']){
                $user->rut = $datos['rut'];
                $cambios++;
            }
            if($user->first_name!=$datos['first_name']){
                $user->first_name = $datos['first_name'];
                $cambios++;
            }
            if($user->last_name!=$datos['last_name']){
                $user->last_name = $datos['last_name'];
                $cambios++;
            }
            if($user->email!=$datos['email']){
                $user->email = $datos['email'];
                $cambios++;
            }
            if($user->carrera->id!=$datos['carrera']){
                $user->carrera()->associate($datos['carrera']);
                $cambios++;
            }
            if($user->roles[0]->id!=$rol->id){
                $user->detachAllRoles();
                $user->attachRole($rol);
                $cambios++;
            }
            if($cambios>0){
                $user->save();
                new Log('Modificar','Usuario',ActualUser(),$user->id);
                $mensaje = ['exito'=>'Se ha modificado el usuario '.$user->name.' correctamente'];
            }
            else{
                $mensaje = ['info'=>'No se han producido cambios en el usuario'];
            }
            return redirect()->route('usuario.list')->with($mensaje);
        }
        else{
            $request->request->add(['defecto'=>'123456']);
            //está modificando solo la clave
            $messages = [
                'password.different' => 'La contraseña debe ser diferente de la clave por defecto',
            ];
            $this->validate($request, [
                'password' => 'required|confirmed|max:8|min:4|different:defecto',
            ],$messages);
            dd($request);
            $user->password = bcrypt($request->password);
            $user->cambiar_password = false;
            $user->save();
            $mensaje = ['exito'=>'Se ha cambiado la clave exitosamente'];
            return redirect()->route('inicio')->with($mensaje);
        }
    }

    public function destroy($id)
    {
        $user = User::where('id',$id)->firstOrFail();
        if($user->id==actualUser()->id){
            $mensaje = ['fallo'=>'El usuario no puede desactivarse a si mismo'];
        }
        else{
            //Reviso que el usuario no tenga ninguna sala ocupada primero
            $tomados = Tomado::where('activo',true)->get();
            $contar = 0;
            foreach($tomados as $tomado){
                if(is_a($tomado->tomable,CargaAcademica::class)){
                    if($tomado->tomable->docente->id==$user->id){
                        $contar++;
                    }
                }
                elseif(is_a($tomado->tomable,Solicitud::class)){
                    if($tomado->tomable->user->id==$user->id){
                        $contar++;
                    }
                }
            }
            if($contar>0){
                $mensaje = ['fallo'=>'El usuario '.$user->name.' no puede desactivarse, ya que tiene salas en uso'];
            }else{
                $user->delete();
                new Log('Inactivar','Usuario',ActualUser(),$user->id);
                $mensaje = ['exito'=>'Se ha desactivado el usuario '.$user->name.' correctamente'];
            }

        }
        return redirect()->route('usuario.list')->with($mensaje);
    }

    public function restore($id){
        $user = User::withTrashed()->where('id',$id)->first();
        $user->restore();
        new Log('Restaurar','Usuario',ActualUser(),$user->id);
        $mensaje = ['exito'=>'Se ha reactivado el usuario '.$user->name];
        return redirect()->route('usuario.list')->with($mensaje);
    }
}
