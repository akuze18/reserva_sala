<?php

use App\Asignatura;
use App\Carrera;
use App\nivel;
use Illuminate\Database\Seeder;

class AsignaturaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carreras = Carrera::all();
        foreach($carreras as $carrera){
            for($nivel=1;$nivel<=($carrera->semestres);$nivel++){
                $Ramos_x_Nivel = rand(4,6);
                for($i=1;$i<=$Ramos_x_Nivel;$i++){
                    $nivel_actual = nivel::where('id',$nivel)->first();
                    $slug = $carrera->slug.($i).'-'.($nivel);
                    $ramo = new Asignatura;
                    $ramo->fill([
                        'slug'=>$slug,
                        'name'=>'Ramo '.($i).' '.$nivel_actual->name,
                        'nivel_id'=>$nivel_actual->id,
                        'carrera_id'=>$carrera->id
                    ])->save();
                }
            }
        }
    }
}
