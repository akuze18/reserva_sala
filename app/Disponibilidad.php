<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Disponibilidad extends Model
{
    protected $table='disponibilidades';

    protected $fillable =['estado','horario_id','sala_id'];

    public function sala(){
        return $this->belongsTo(Sala::class);
    }
    public function horario(){
        return $this->belongsTo(Horario::class);
    }
    public function cargas_academicas(){
        return $this->hasMany(CargaAcademica::class,'disponibilidad_id');
    }
    public function tomado_por(){
        return $this->hasMany(Tomado::class,'disponibilidad_id');
    }

    /**
     * @return \App\Tomado|null|static
     */
    public function tomado_actual(){
        return $this->tomado_por()->where('activo',true)->first();
    }

    public function scopeBuscar(Builder $query,$edificio,$piso,$capacidad,$modulo,$dia,$sala=null,$docente=false){
        if(!is_null($edificio)){
            $getPisos = Piso::select('id')->where('edificio_id',$edificio)->get()->toArray();
            $getSalas = Sala::select('id')->whereIn('piso_id',$getPisos)->get()->toArray();
            $query = $query->whereIn('sala_id',$getSalas);
        }
        if(!is_null($piso)){
            $getPisos = Piso::select('id')->where('name',$piso)->get()->toArray();
            $getSalas = Sala::select('id')->whereIn('piso_id',$getPisos)->get()->toArray();
            $query = $query->whereIn('sala_id',$getSalas);
        }
        if(!is_null($sala)){
            $query = $query->where('sala_id',$sala);
        }

        if(!is_null($capacidad)){
            $getSalas = Sala::select('id')->where('capacidad',$capacidad)->get()->toArray();
            $query = $query->whereIn('sala_id',$getSalas);
        }

        if(!is_null($dia)){

            $getHorario=Horario::select('id')->where('dia_id',$dia)
                ->get()->toArray();
            $query = $query->whereIn('horario_id',$getHorario);
        }

        if(!is_null($modulo)){
            $getHorario=Horario::select('id')->where('modulo_id',$modulo)->get()->toArray();
            $query = $query->whereIn('horario_id',$getHorario);
        }

        if(!($docente)){
            $query = $query->where('estado','Disponible');
        }
        else{
            //docente puede tomar aquellas disponibles y aquellas que este solicitadas por alumnos
            $query = $query->Where(function(Builder $subquery){
                //Se anida para que haga conjunción con los otros where de los filtros
                $tomados = Tomado::select('t.disponibilidad_id')
                    ->from('tomados as t')
                    ->join('solicitudes as s','s.id','=','t.tomable_id')
                    ->join('users as u','u.id','=','s.user_id')
                    ->where('t.tomable_type','App\Solicitud')
                    ->where('t.activo',true)
                    ->where('u.perfil','alumno')
                    ->get()->toArray();
                $subquery->where('estado','Ocupado')
                    ->whereIn('id',$tomados);
                $subquery->Orwhere('estado','Disponible');
            });
        }
        //dd($query);
        return $query;
    }
}
