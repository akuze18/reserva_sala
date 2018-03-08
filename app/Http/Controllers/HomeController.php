<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index(Request $request)
    {
        if(Auth::guest()){
            return view('publico_general.home');
        }
        else{
            $request->session()->reflash();
            return redirect()->route('ingreso_sistema');
        }
    }

    public function login(){
        $url = URL::route('inicio', array('#sistema'));
        return redirect()->to($url);
    }

    public function sistema_home(){
        return view('sistema.home');
    }

    public function deniedRole(Request $request){
        $target = $request->session()->previousUrl();
        return view('vendor.ultraware_roles.no_role_required',compact('target'));
    }

    public function TODO(Request $request){
        echo "<script>alert('".$request->path()."\\n"."En Construccion'); window.location.assign('".$request->session()->previousUrl()."') </script>";
    }
}
