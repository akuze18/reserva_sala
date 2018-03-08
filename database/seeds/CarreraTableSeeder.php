<?php

use App\Carrera;
use Illuminate\Database\Seeder;

class CarreraTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<10;$i++) {
            Carrera::Create([
                'name' => 'Carrera '.$i,
                'slug' => chr($i+64),        //en 65 inicia la A hasta 90 que es Z
                'semestres' => rand(2,6)*2
            ]);
        }
    }
}
