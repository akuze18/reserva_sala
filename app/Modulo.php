<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable=['hora_inicio','hora_fin','name'];

    public function horarios(){
        return $this->hasMany(Horario::class);
    }

    public function getFullNameAttribute(){
        return $this->name.': '.$this->hora_inicio_f.' - '.$this->hora_fin_f;
    }

    public function getHoraInicioFAttribute(){
        return date('H:i',strtotime($this->hora_inicio));
    }
    public function getHoraFinFAttribute(){
        return date('H:i',strtotime($this->hora_fin));
    }
}
