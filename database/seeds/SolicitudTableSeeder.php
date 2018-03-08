<?php

use App\Disponibilidad;
use App\Solicitud;
use App\Tomado;
use Illuminate\Database\Seeder;
use App\Consultas\Main as Consultas;

class SolicitudTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $consultas = new Consultas();
        $alumnos = $consultas->alumnos()->all();
        $docentes = $consultas->docentes()->all();
        $horarios = $consultas->horarios()->todos();
        $salas = $consultas->salas()->all();
        $motivos = $consultas->motivos()->creacion();

        $faker = Faker\Factory::create();

        foreach($alumnos as $alumno){
            $contar = 1;
            $cantidad=rand(15,30);   //por alumno entre 15 a 30 solicitudes
            while($contar<=$cantidad){
                $horario = $horarios->random();
                $sala = $salas->random();
                $disponibilidad = $consultas->disponibilidades()->getByHorarioSala($horario->id,$sala->id);
                $motivo = $motivos->random();
                $contar = $this->solicitar($alumno,$contar,$faker,$horario,$sala,$disponibilidad,$motivo);
            }
        }
        foreach($docentes as $docente){
            $contar = 1;
            $cantidad=rand(5,12);   //por docente entre 5 a 12 solicitudes
            while($contar<=$cantidad){
                $horario = $horarios->random();
                $sala = $salas->random();
                $disponibilidad = $consultas->disponibilidades()->getByHorarioSala($horario->id,$sala->id);
                $motivo = $motivos->random();
                $contar = $this->solicitar($docente,$contar,$faker,$horario,$sala,$disponibilidad,$motivo);
            }
        }

    }

    private function solicitar($usuario,$contar, Faker\Generator $faker, $horario, $sala, $disponibilidad, $motivo)
    {
        if(is_null($disponibilidad)){
            //Creo la disponibilidad
            $disponibilidad = new Disponibilidad();
            $disponibilidad->fill(['estado'=>'Disponible']);
            $disponibilidad->horario()->associate($horario);
            $disponibilidad->sala()->associate($sala);
            $disponibilidad->save();
        }
        //chequeo si esta tomada
        if(is_null($disponibilidad->tomado_actual())){
            //no está tomada, la puedo solicitar
            $solicitud = new Solicitud();

            $solicitud->fill([
                'estado'=>'Aceptada',
                'created_at'=>$faker->dateTimeBetween('-5 months','now')
            ]);
            $solicitud->motivo()->associate($motivo);
            $solicitud->sala()->associate($sala);
            $solicitud->user()->associate($usuario);
            $solicitud->horario()->associate($horario);
            $solicitud->save();

            //ocupo la disponibilidad
            $disponibilidad->estado = 'Ocupado';
            $disponibilidad->save();
            //y la tomo
            $tomado = new Tomado();
            $tomado->fill([
                'disponibilidad_id'=>$disponibilidad->id,
                'tomable_id'=>$solicitud->id,
                'tomable_type'=> Solicitud::class
            ])->save();
            $contar++;
        }
        else{
            //no la puedo tomar, ya esta tomada
        }
        return $contar;
    }
}
