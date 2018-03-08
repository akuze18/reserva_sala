<?php

use App\Motivo;
use Illuminate\Database\Seeder;

class MotivoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $creaciones = ['Reunion Estudio','Trabajo Grupal','Actividad Recreativa','Actividad Extracurricular','Presentacion'];
        $rechazos = ['No procede','Reasignada'];
        foreach($creaciones as $creacion){
            Motivo::create(['action'=>'creacion','descripcion'=>$creacion]);
        }
        foreach($rechazos as $rechazo){
            Motivo::create(['action'=>'rechazo','descripcion'=>$rechazo]);
        }
    }
}
