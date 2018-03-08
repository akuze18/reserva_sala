<?php

use App\Dia;
use Illuminate\Database\Seeder;

class DiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dia::create(['es'=>'Lunes','activo'=>true]);
        Dia::create(['es'=>'Martes','activo'=>true]);
        Dia::create(['es'=>'Miercoles','activo'=>true]);
        Dia::create(['es'=>'Jueves','activo'=>true]);
        Dia::create(['es'=>'Viernes','activo'=>true]);
        Dia::create(['es'=>'Sabado','activo'=>true]);
        Dia::create(['es'=>'Domingo','activo'=>false]);
    }
}
