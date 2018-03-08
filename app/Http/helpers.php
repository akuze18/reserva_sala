<?php

use App\Tomado;
use App\User;
use Illuminate\Support\Facades\Auth;

function estado_aprov_color($estado, Tomado $tomado = null){
    if($estado=='Disponible'){
        $color = 'success';
    }
    elseif($estado=='Ocupado'){
        if(is_null($tomado)){
            $color ='danger';
        }
        else{
            if(is_a($tomado->tomable,\App\CargaAcademica::class)){
                $color ='CA';
            }
            elseif(is_a($tomado->tomable,\App\Solicitud::class)){
                if($tomado->tomable->user->perfil == 'docente'){
                    $color ='docente';
                }
                else{
                    $color ='alumno';
                }

            }
            else{$color ='danger';}

        }
    }
    elseif($estado=='Pendiente'){
        $color = 'warning';
    }
    else{
        $color = 'none';
    }
    return $color;
}

/**
 * @return User
 */
function actualUser(){
    return Auth::user();
}

function paginacion_BS4(){
    return 'vendor.pagination.bootstrap-4';
}

function labels($minusculas = false){
    $etiquetas = [
        'password'=>'Nueva Clave',
        'password_confirmation'=>'Repita la Clave',
        'name'=>'Nombre',
        'capacidad'=>'Capacidad',
        'piso'=>'Piso',
        'piso_id' =>'Piso',
        'edificio_id' => 'Edificio',
        'edificio'=>'Edificio',
        'sala_id'=>'Sala',
        'docente_id'=>'Docente',
        'carrera_id'=>'Carrera',
        'asignatura_id'=>'Asignatura',
        'save'=>'Guardar',
        'modulo'=>'Modulo',
        'modulo_id'=>'Modulo',
        'dia'=>'Dia de Semana',
        'dia_id'=>'Dia de Semana',
        'motivo'=>'Motivo',
        'accion'=>'Accion',
        'descripcion'=>'descripcion',
        'carrera'=>'Carrera',
        'asignatura'=>'Ramo',
        'nivel'=>'Semestre',
        'docente'=>'Docente',
        'rut'=>'RUT',
        'first_name'=>'Nombre',
        'last_name'=>'Apellido',
        'email'=>'Correo Electronico',
        'perfil'=>'Perfil',
        'permissions'=>'Permisos',
        'description'=>'Descripcion',
        'slug'=>'Codigo',

        'find'=>'Buscar',
        'filter'=>'Filtrar',
        'reset'=>'Limpiar',
        'desde'=>'desde',
        'hasta'=>'hasta',

        'semestres'=>'Maximo de Semestres',
        ''=>'',
    ];
    if($minusculas){
        foreach($etiquetas as $clave=>$valor){$etiquetas[$clave] = strtolower($valor);}
    }
    return $etiquetas;
}

function fData($eName,$eVal=null,$elements=[],$enable=true,$len=null,$minimo=false,$requerido=true,$len_min = null)
{

    if ( !is_null($eVal) and count($eVal)==0  and count($elements)>0 ) {
        $existe = false;
        foreach ($elements as $element) {
            if ($element->id == $eVal) {
                $existe = true;
            }
        }
        if (!$existe) {
            $eVal = null;
        }
    }
    $groups = [];
    //echo gettype($elements);
    if(gettype($elements)=='object'){
        $cl = (get_class($elements));
        //echo $cl;
        $obj = new $cl();
        if($cl=='Illuminate\Database\Eloquent\Collection'){
            $def_grupos = true;
        }
        else{
            $def_grupos = false;
            if (!is_int($len)) {
                $len = 0;
            }
            if(is_a($obj,'App\solicitudAction')) {
                $len += count($obj::where('type', $elements->type)->all());
            }
            else {
                $len += count($obj->all());
            }
        }
    }
    else{
        $def_grupos = true;
    }


    if($def_grupos){
        foreach($elements as $element){
            //$cl = (get_class($element));
            if(!is_null($element->group)){
                if(!in_array($element->group,$groups)){
                    $groups = array_add($groups,$element->group,[]);
                }
                try{
                    array_push($groups[$element->group],$element);
                }
                catch(Exception $e){
                    //dd($groups);
                    dd($element->group);
                    dd($groups[$element->group]);
                }
            }
            else{
                if(!in_array('',$groups)){
                    $groups = array_add($groups,'',[]);
                }
                array_push($groups[''],$element);
            }
        }
    }


    $vars =  [
        'eName'=>str_replace('.','_',$eName),
        'eLabel'=>$eName,
        'eVal'=>$eVal,
        'elements'=>$elements,
        'enable'=>$enable,
        'len'=>$len,
        'len_min'=>$len_min,
        'groups' => $groups,
        'minimo' => $minimo,
        'requerido' =>$requerido
    ];



    return $vars;
}

function fecha_desde(){
    $fecha = new datetime();
    $inicial = $fecha->modify('first day of');
    return $inicial;
}

function fecha_hasta(){
    $fecha = new datetime();
    $final = $fecha->modify('last day of');
    return $final;
}
