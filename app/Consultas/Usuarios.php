<?php

namespace App\Consultas;

use App\User;
use Illuminate\Support\Facades\DB;

class Usuarios {

    public function reporteSolicitanteTop($desde,$hasta,$top,$pagina=null){
        $consulta = User::select('users.id','users.rut','users.first_name','users.last_name','users.email','users.carrera_id','users.deleted_at',(DB::raw('count(s.id) as usos_count')))
            ->join('solicitudes as s','s.user_id','=','users.id')
            ->where('s.created_at','>=',$desde)
            ->where('s.created_at','<=',$hasta.' 23:59:59.999')
            ->groupBy('users.id','users.rut','users.first_name','users.last_name','users.email','users.carrera_id','users.deleted_at')
            ->orderBy('usos_count','desc')
            ->take($top);
        if(is_null($pagina)){
            return $consulta->get();
        }
        else{
            return $consulta->paginate($pagina);
        }


    }
}