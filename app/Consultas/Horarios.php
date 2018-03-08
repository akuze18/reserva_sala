<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 11:37
 */

namespace App\Consultas;

use App\Horario;
use Illuminate\Support\Facades\DB;

class Horarios {

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function todos(){
        return Horario::all();
    }

    /**
     * @param $horario_id integer
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function byId($horario_id){
        return Horario::where('id',$horario_id);
    }

    /**
     * @param $dia_id integer
     * @param $modulo_id integer
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function byDiaModulo($dia_id,$modulo_id){
        return Horario::where('modulo_id',$modulo_id)->where('dia_id',$dia_id);
    }

    public function reporteTop($desde,$hasta,$top,$pagina=null){
        $info = Horario::select('h.id','h.modulo_id','h.dia_id',(DB::raw('count(s.id) as usos_count')))
            ->from('horarios as h')
            ->join('solicitudes as s','s.horario_id','=','h.id')
            ->where('s.created_at','>=',$desde)
            ->where('s.created_at','<=',$hasta.' 23:59:59.999')
            ->groupBy('h.id','h.modulo_id','h.dia_id')
            ->orderBy('usos_count','desc')
            ->take($top);
        if(is_null($pagina)){
            return $info->get();
        }
        else{
            return $info->paginate($pagina);
        }
    }
}