<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 20/10/2017
 * Time: 13:26
 */

namespace App\Logs;


class Consultas {
    public function reporte($desde,$hasta,$pagina=null){
        $consulta = Modelo::where('created_at','>=',$desde)
            ->where('created_at','<=',$hasta.' 23:59:59.999')
            ->orderBy('created_at','desc');
        if(is_null($pagina)){
            return $consulta->get();
        }
        else{
            return $consulta->paginate(15);
        }
    }
}