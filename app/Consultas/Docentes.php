<?php
/**
 * Created by PhpStorm.
 * User: aquispe
 * Date: 19/10/2017
 * Time: 11:17
 */

namespace App\Consultas;

use App\User;

class Docentes {
    private $tipo = 'docente';

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function listar(){
        return User::select('users.*')->
            join('role_user as RU','users.id','=','RU.user_id')->
            join('roles as R','RU.role_id','=','R.id')->
            where('R.slug',$this->tipo);
    }
    /**
     * @param $docente_id integer
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function byId($docente_id){
        return User::select('users.*')->
        join('role_user as RU','users.id','=','RU.user_id')->
        join('roles as R','RU.role_id','=','R.id')->
        where('users.id',$docente_id)->
        where('R.slug',$this->tipo);

    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all(){
        return $this->listar()->get();
    }

    /**
     * @param $cantidad integer
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function pag($cantidad){
        return $this->listar()->paginate($cantidad);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function allByName(){
        return $this->listar()->orderBy('first_name')->orderBy('last_name')->get();
    }

    /**
     * @param $docente_id
     * @return \App\User
     */
    public function firstFailById($docente_id){
        return $this->byId($docente_id)->firstOrFail();
    }

    /**
     * @param $docente_id
     * @return \App\User
     */
    public function firstById($docente_id){
        return $this->byId($docente_id)->first();
    }
}