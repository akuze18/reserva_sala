<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $fillable=['es','activo'];

    public function getNameAttribute(){
        return $this->es;
    }

}
