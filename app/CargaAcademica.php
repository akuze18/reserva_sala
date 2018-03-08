<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class CargaAcademica extends Model
{
    protected $fillable=['docente_id','asignatura_id','horario_id','sala_id'];

    public function docente(){
        return $this->belongsTo(User::class,'docente_id');
    }

    public function asignatura(){
        return $this->belongsTo(Asignatura::class,'asignatura_id');
    }

    public function horario(){
        return $this->belongsTo(Horario::class,'horario_id');
    }

    public function sala(){
        return $this->belongsTo(Sala::class,'sala_id');
    }

    public function tomado()
    {
        return $this->morphMany(Tomado::class, 'tomable');
    }


    /**
     * @return Tomado
     */
    public function tomado_actual(){
        return $this->tomado->where('activo',true)->first();
    }

    public function scopeBuscar(Builder $query,$docente,$carrera,$nivel,$asignatura,$modulo,$dia){
        if(!is_null($docente)){
            $query = $query->where('docente_id',$docente);
        }
        if(!is_null($carrera)){
            $getAsignaturas = Asignatura::select('id')->where('carrera_id',$carrera)->get()->toArray();
            $query = $query->whereIn('asignatura_id',$getAsignaturas);
        }
        if(!is_null($nivel)){
            $getAsignaturas = Asignatura::select('id')->where('nivel_id',$nivel)->get()->toArray();
            $query = $query->whereIn('asignatura_id',$getAsignaturas);
        }
        if(!is_null($asignatura)){
            $query = $query->where('asignatura_id',$asignatura);
        }
        if(!is_null($modulo)){
            $getHorario = Horario::select('id')->where('modulo_id',$modulo)->get()->toArray();
            $query = $query->whereIn('horario_id',$getHorario);
        }
        if(!is_null($dia)){
            $getHorario = Horario::select('id')->where('dia_id',$dia)->get()->toArray();
            $query = $query->whereIn('horario_id',$getHorario);
        }

        return $query;
    }
}
