<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $fillable =['name','capacidad','estado','piso_id'];

    public function piso(){
        return $this->belongsTo(Piso::class);
    }

    public function disponibles(){
        return $this->hasMany(Disponibilidad::class);
    }

    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }

    public function getLongNameAttribute(){
        return 'Sala '.$this->name.' Edificio '.$this->piso->edificio->name;
    }

    public function scopeBuscar(Builder $query, $edificio_name){
        if (!is_null($edificio_name)) {
            $edificio = Edificio::where('name', $edificio_name)->first();
            $id_pisos = Piso::select('id')->where('edificio_id',$edificio->id)->get()->toArray();
            $query = $query->whereIn('piso_id', $id_pisos);
        }
        return $query;
    }

    public function scopeExtraer(Builder $query,$sala_id,$piso_id,$edificio_id){
        if(!is_null($sala_id)){
            $query = $query->where('id',$sala_id);
        }
        if(!is_null($piso_id)){
            $query = $query->where('piso_id',$piso_id);
        }
        if(!is_null($edificio_id)){
            $id_pisos = Piso::select('id')->where('edificio_id',$edificio_id)->get()->toArray();
            $query = $query->whereIn('piso_id', $id_pisos);
        }
        return $query;
    }

}
