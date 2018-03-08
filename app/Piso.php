<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Piso extends Model
{
    protected $fillable=['name','edificio_id'];

    public function edificio(){
        return $this->belongsTo(Edificio::class);
    }

    public function salas(){
        return $this->hasMany(Sala::class);
    }

    public function getLongNameAttribute(){
        return $this->name.' Edificio ' .$this->edificio->name;
    }
}
