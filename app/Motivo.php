<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
    protected $fillable=['action','descripcion'];

    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }

    public function getFullNameAttribute(){
        return $this->descripcion;
    }
    public function getActionNameAttribute(){
        return ucwords($this->action);
    }
}
