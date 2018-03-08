<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Edificio extends Model
{
    protected $fillable =['name'];

    public function pisos(){
        return $this->hasMany(Piso::class);
    }

    public function maxSalas(){
        $actual = 0;
        foreach($this->pisos as $piso){
            if($piso->salas->count()>$actual){
                $actual = $piso->salas->count();
            }
        }
        return $actual;
    }

}
