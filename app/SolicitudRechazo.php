<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudRechazo extends Model
{
    protected $fillable =['solicitud_id','motivo_id'];

    public function motivo(){
        return $this->belongsTo(Motivo::class);
    }

    public function solicitud(){
        return $this->belongsTo(Solicitud::class,'solicitud_id','id');
    }
}
