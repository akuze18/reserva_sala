<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable=['modulo_id','dia_id'];

    public function modulo(){
        return $this->belongsTo(Modulo::class);
    }
    public function dia(){
        return $this->belongsTo(Dia::class,'dia_id');
    }
    public function disponibles(){
        return $this->hasMany(Disponibilidad::class);
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }

    public function getDisplayAttribute(){
        return 'Modulo '.$this->modulo->name.' - '.$this->dia->name;
    }

    public function getDisplayFullAttribute(){
        return 'Modulo '.$this->modulo->full_name.' - '.$this->dia->name;
    }


    public function scopeExtraer(Builder $query,$horario_id,$modulo_id,$dia_id){
        if(!is_null($horario_id)){
            $query = $query->where('id',$horario_id);
        }
        if(!is_null($modulo_id)){
            $query = $query->where('modulo_id',$modulo_id);
        }
        if(!is_null($dia_id)){
            $query = $query->where('dia_id',$dia_id);
        }
        return $query;
    }
}
