<?php

namespace App\Consultas;

use App\Carrera;
use Illuminate\Support\Facades\DB;

class Carreras {

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function todos(){
        return Carrera::all();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function allByName(){
        return Carrera::orderBy('name')->get();
    }

    public function reporteTop($desde,$hasta,$top,$pagina=null){
        //DB::enableQueryLog();
        $consulta = Carrera::select('carreras.id','carreras.slug','carreras.name','carreras.semestres',
            (DB::raw('count(s.id) as usos_count')))
            ->join('users as u','u.carrera_id','=','carreras.id')
            ->join('solicitudes as s','s.user_id','=','u.id')
            ->where('s.created_at','>=',$desde)
            ->where('s.created_at','<=',$hasta.' 23:59:59.999')
            ->groupBy('carreras.id','carreras.slug','carreras.name','carreras.semestres')
            ->orderBy('usos_count','desc')
            ->limit($top);
        //$log = DB::getQueryLog();
        //dd($log);
        //dd($consulta);
        if(is_null($pagina)){
            return $consulta->get();
        }
        else{

            return $consulta->paginate($pagina);
        }
    }
}