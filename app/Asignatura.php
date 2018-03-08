<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $fillable =['slug','name','nivel_id','carrera_id'];

    public function carrera(){
        return $this->belongsTo(Carrera::class,'carrera_id');
    }
    public function nivel(){
        return$this->belongsTo(nivel::class,'nivel_id');
    }

    public function cargas_academicas(){
        return $this->hasMany(CargaAcademica::class,'asignatura_id');
    }

}
