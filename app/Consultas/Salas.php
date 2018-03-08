<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 12:21
 */

namespace App\Consultas;


use App\Sala;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class Salas {
    /**
     * @param $piso_integer
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByPiso($piso_id){
        return Sala::where('piso_id',$piso_id)->get();
    }

    public function all(){
        return Sala::all();
    }


    public function reporteTop($desde,$hasta,$top,$pagina=null){
        $info = Sala::select('s.id','s.name','s.capacidad','s.piso_id',(DB::raw('count(s.id) as usos_count')))
            ->from('salas as s')
            ->join('solicitudes as sol','sol.sala_id','=','s.id')
            //->join('tomados as t','t.disponibilidad_id','=','d.id')
            //->where('t.tomable_type','=','App\Solicitud')
            ->where('sol.created_at','>=',$desde)
            ->where('sol.created_at','<=',$hasta.' 23:59:59.999')
            ->groupBy('s.id','s.name','s.capacidad','s.piso_id')
            ->orderBy('usos_count','desc')
            ->take($top);
        //dd($info->get());
        //$info = new LengthAwarePaginator($info->get(),5,$info->count(),Input::get('page'));
        if(is_null($pagina)){
            return $info->get();
        }
        else{
            return $info->paginate($pagina);
        }

    }
}