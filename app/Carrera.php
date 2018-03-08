<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Carrera extends Model
{
    protected $fillable =['slug','name','semestres'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function asignaturas(){
        return $this->hasMany(Asignatura::class);
    }

}
