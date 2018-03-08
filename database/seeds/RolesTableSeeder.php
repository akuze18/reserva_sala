<?php

use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['Administrador','admin','Master del Sistema'],
            ['Operador','operador','Visualizador de solicitudes'],
            ['Docente','docente','Visualizador de solicitudes'],
            ['Alumno','alumno','Visualizador de solicitudes']
        ];
        foreach($roles as $infoRole){
            $role = new Role();
            $role->fill([
                'name' => $infoRole[0],
                'slug' => $infoRole[1],
                'description' => $infoRole[2],
            ])->save();
        }
    }
}
