<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

class PermisosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $models = [
            ['User', 'actions' => ['Create', 'Disable', 'List', 'See', 'Edit']],
            ['Solicitud', 'actions' => ['Create', 'List', 'See', 'Edit']],
            ['MiSolicitud', 'actions' => ['List', 'See']],   //evaluar si colocar edit en mi solicitud ,'Edit'
            ['MiCargaAcademica', 'actions' => ['List', 'See']],
            ['Sala', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Motivo', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Disponible', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit', 'Find']],
            ['Reporte', 'actions' => ['List', 'See']],
            ['CargaAcademica', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit', 'Find']],
            ['Perfil', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Edificio', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Piso', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Carrera', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Asignatura', 'actions' => ['Create', 'Delete', 'List', 'See', 'Edit']],
            ['Docente', 'actions' => ['Find']]
        ];
        $admin = Role::where('slug', 'Admin')->first();
        $operador = Role::where('slug', 'operador')->first();
        foreach ($models as $model) {
            foreach ($model['actions'] as $action) {
                $slug = $action . '.' . $model[0];
                $counter = Permission::where('slug', $slug)->count();
                if ($counter == 0) {
                    $permiso = new Permission;
                    $permiso->fill([
                        'name' => trans('permiso.'.$action) . ' ' . trans('permiso.'.$model[0]),
                        'slug' => $slug,
                        'description' => '', // optional
                        'model' => $model[0]
                    ])->save();
                } else {
                    $permiso = Permission::where('slug', $slug)->first();
                }
                if (($action == 'See' or $action == 'List') and ($model[0] != 'MiSolicitud' and $model[0] != 'MiCargaAcademica')) {
                    //Permisos para el rol OPERADOR
                    $operador->attachPermission($permiso);
                }
                if (($action != 'Find') and ($model[0] != 'MiSolicitud' and $model[0] != 'MiCargaAcademica')) {
                    $admin->attachPermission($permiso); // permission attached to a role
                }

            }
        }

        //Permisos para el rol Docente
        $docente = Role::where('slug', 'docente')->first();
        $slug_docente = ['find.docente',
            'find.disponible',
            'create.solicitud',
            'list.misolicitud',
            'see.misolicitud',
            'list.micargaacademica',
            'see.micargaacademica'];
        $permisos_docente = Permission::whereIn('slug',$slug_docente)->get();
        foreach ($permisos_docente as $permiso) {
            $docente->attachPermission($permiso);
        }
        //Permisos para el rol Alumno
        $alumno = Role::where('slug','alumno')->first();
        $slug_alumno = ['find.docente',
            'find.disponible',
            'create.solicitud',
            'list.misolicitud',
            'see.misolicitud'];
        $permisos_alumno = Permission::whereIn('slug',$slug_alumno)->get();
        foreach ($permisos_alumno as $permiso) {
            $alumno->attachPermission($permiso);
        }
    }

}


