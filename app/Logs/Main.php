<?php

namespace App\Logs;

use App\User;

class Main
{
    public function __construct($action, $modulo, User $user,$object_id = null, $motivo = null, $info_adicional = ''){

        $valores = [
            'accion' => $action,
            'modulo' => $modulo,
            'object_id'=> $object_id,
            'info_adicional' => $info_adicional
        ];
        $log = new Modelo();
        $log->fill($valores);
        $log->user()->associate($user);
        if(!is_null($motivo)){
            $log->motivo()->associate($motivo);
        }
        $log->save();
    }

}
