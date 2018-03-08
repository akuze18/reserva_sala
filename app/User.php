<?php

namespace App;

use App\Notifications\MyRecoveryPassword;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
//use Ultraware\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
//use Ultraware\Roles\Models\Role;
//use Ultraware\Roles\Traits\HasRoleAndPermission;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    HasRoleAndPermissionContract
{
    use Authenticatable, Authorizable, CanResetPassword,HasRoleAndPermission;
    use SoftDeletes;
    use Notifiable;

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut','first_name','last_name', 'email', 'password', 'cambiar_password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function carrera(){
        return $this->belongsTo(Carrera::class,'carrera_id');
    }
    public function solicitudes(){
        return $this->hasMany(Solicitud::class);
    }
    public function cargas_academicas(){
        return $this->hasMany(CargaAcademica::class,'docente_id');
    }

    public function getNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getCambiarPassAttribute(){
        //dd( boolval($this->cambiar_password));
        return boolval($this->cambiar_password);
    }

    public function scopeBuscarPerfil(Builder $query,$perfil=''){
        if($perfil!=''){
            $query = $query->
                    select('users.*')->
                    join('role_user as n','n.user_id','=','users.id')->
                    join('roles as r','r.id','=','n.role_id')->
                    where('r.slug',$perfil);
        }
        return $query;
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyRecoveryPassword($token));
    }


}
