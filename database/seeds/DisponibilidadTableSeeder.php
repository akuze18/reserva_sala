<?php

use App\Disponibilidad;
use App\Horario;
use App\Sala;
use Illuminate\Database\Seeder;

class DisponibilidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $salas = Sala::all();
        $horarios = Horario::all();
        $estado = ['Disponible','Deshabilitado'];
        foreach($salas as $sala){
            foreach($horarios as $horario){
                $newEstado = $estado[array_rand($estado)];
                $disponibilidad = Disponibilidad::where('horario_id',$horario->id)
                    ->where('sala_id',$sala->id)->first();
                if(is_null($disponibilidad)){
                    $newDisponibilidad = new Disponibilidad();
                    $newDisponibilidad->fill([
                        'estado'=>$newEstado,
                        'horario_id'=>$horario->id,
                        'sala_id'=>$sala->id
                    ])->save();
                }
            }
        }
    }
}
