<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table='solicitudes';
    protected $fillable=['estado','motivo_id','sala_id','user_id','horario_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sala(){
        return $this->belongsTo(Sala::class);
    }
    public function horario(){
        return $this->belongsTo(Horario::class);
    }
    public function rechazo(){
        return $this->hasOne(SolicitudRechazo::class,'solicitud_id','id');
    }

    public function motivo(){
        return $this->belongsTo(Motivo::class);
    }
    public function tomado()
    {
        return $this->morphMany(Tomado::class, 'tomable');
    }

    public function scopeEstado(Builder $query, $estado){
        if (!is_null($estado)) {
            $query = $query->where('estado', $estado);
        }

        return $query->orderByDesc('created_at');

    }

    public function getFechaAttribute(){
        return date('d-m-Y',strtotime($this->created_at));
    }
}
