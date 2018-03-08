<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Logs\Main as Log;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords{
        resetPassword as protected accion;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function resetear(Request $request){
        $request->request->add(['defecto'=>'123456']);
        return $this->reset($request);
    }

    public function rules()
    {

        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|max:8|min:4|different:defecto',
        ];
    }

    public function validationErrorMessages(){
        return [
            'password.different' => 'La contraseña debe ser diferente de la clave por defecto',
        ];
    }

    public function resetPassword($user, $password){

        $user->cambiar_password = false;
        $user->save();
        $this->accion($user,$password);
        new Log('Reseteo Pass','Logueo',$this->guard()->user());
        new Log('Login','Logueo',$this->guard()->user());
    }
}
