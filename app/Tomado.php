<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tomado extends Model
{
    protected $fillable = ['disponibilidad_id','tomable_id','tomable_type'];

    public function disponibilidad(){
        return $this->belongsTo(Disponibilidad::class);
    }
    public function tomable()
    {
        return $this->morphTo();
    }

    public function info(){
        $mensaje = '';
        if(is_a($this->tomable,CargaAcademica::class)){
            $mensaje = $this->tomable->docente->name.'<br>'.$this->tomable->asignatura->name;
        }
        elseif(is_a($this->tomable,Solicitud::class)){
            $mensaje = $this->tomable->user->name.'<br>'.$this->tomable->motivo->descripcion;
        }
        return $mensaje;
    }
}
