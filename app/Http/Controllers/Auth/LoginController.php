<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Logs\Main as Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers{
        sendLoginResponse as protected accion;
        logout as protected salir;
    }

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'email';
    }

    public function ingreso(Request $request){
        //dd($request->session());
        $email_a = $request->get($this->username());
        if(!filter_var($email_a, FILTER_VALIDATE_EMAIL)){
            //si no es un correo, entonces es solo name, le agrego el correo
            $request->merge(array($this->username() => $email_a.'@inacapmail.cl'));
        }
        return $this->login($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        new Log('Login','Logueo',$this->guard()->user());
        return $this->accion($request);
    }

    public function logout(Request $request){
        new Log('Logout','Logueo',$this->guard()->user());
        return $this->salir($request);
    }
}
