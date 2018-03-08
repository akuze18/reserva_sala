<?php

use App\Carrera;
use App\User;
use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $carreras = Carrera::all();
        $perfiles = ['alumno','docente','operador'];

        $defecto = [
            ['15106218-0','Ariel','Quispe','admin']
        ];

        foreach($defecto as $data){
            $carrera = $carreras->random();
            $user = new User;
            $user->fill([
                'rut' => $data[0],
                'first_name' => $data[1],
                'last_name'=> $data[2],
                'email' => strtolower($data[1].'.'.$data[2].'@gmail.com'),
                'password' => bcrypt('123456'),
                'carrera_id' => $carrera->id,
            ])->save();
            $role = Role::where('slug',$data[3])->first();
            $user->attachRole($role);
        }

        for($i=0;$i<10;$i++){
            $unacarrera = $carreras->random();
            $perfil = $perfiles[array_rand($perfiles)];
            $first_name = $faker->firstName;
            $last_name = $faker->lastName;
            $user = new User;
            $user->fill([
                'rut' => $faker->phoneNumber,
                'first_name' => $first_name,
                'last_name'=> $last_name,
                'email' => strtolower($first_name.'.'.$last_name.'@'.$faker->safeEmailDomain),
                'password' => bcrypt('123456'),
                'carrera_id' => $unacarrera->id,
            ])->save();
            $role = Role::where('slug',$perfil)->first();
            $user->attachRole($role);
        }

    }
}
