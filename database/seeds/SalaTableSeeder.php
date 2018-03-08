<?php

use App\Piso;
use App\Sala;
use Illuminate\Database\Seeder;

class SalaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pisos = Piso::all();
        foreach($pisos as $piso){
            for($i=0;$i<5;$i++){
                Sala::create([
                    'name' =>$piso->name.'0'.($i),
                    'capacidad'=>rand(15,25)*2,
                    //,'estado'=>'disponible',
                    'piso_id'=>$piso->id
                ]);
            }
        }

    }
}
