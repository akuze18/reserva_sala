<?php

use App\Dia;
use App\Horario;
use App\Modulo;
use Illuminate\Database\Seeder;

class HorarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modulos = Modulo::all();
        $dias = Dia::where('activo',true)->get();
        foreach($modulos as $modulo){
            foreach($dias as $dia){
                Horario::create([
                    'dia_id'=>$dia->id,
                    'modulo_id'=>$modulo->id
                ]);
            }

        }
    }
}
