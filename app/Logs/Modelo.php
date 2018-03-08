<?php

namespace App\Logs;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Motivo;

class Modelo extends Model
{
    protected $table = 'logs';

    protected $fillable = ['accion','modulo','object_id','info_adicional'];

    public function motivo(){
        return $this->belongsTo(Motivo::class,'motivo_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function getFechaAttribute(){
        return date('Y-m-d H:i',strtotime($this->created_at));
    }
}
