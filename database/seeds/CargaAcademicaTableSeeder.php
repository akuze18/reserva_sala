<?php

use App\Asignatura;
use App\CargaAcademica;
use App\Dia;
use App\Disponibilidad;
use App\Horario;
use App\Sala;
use App\Tomado;
use Illuminate\Database\Seeder;
use Ultraware\Roles\Models\Role;

class CargaAcademicaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Por cada Docente
        $rolDocente = Role::where('slug','docente')->first();
        $salas = Sala::all();
        $asignaturas = Asignatura::all();
        foreach($rolDocente->users as $docente){
            //por cada horario (dia-modulo) //excepto los sabados
            $sabado = Dia::where('es','Sabado')->first();
            $horarios = Horario::where('dia_id','<>',$sabado->id)->get();
            foreach($horarios as $horario){
                //le asigno una sala y asignatura aleatoria
                do{
                    $sala = $salas->random();
                    $asignatura = $asignaturas->random();
                    //chequeo si algun otro docente tiene tomado la misma disponibilidad (sala-horario)
                    $disponibilidad = Disponibilidad::where('horario_id',$horario->id)
                        ->where('sala_id',$sala->id)->first();
                }while(!is_null($disponibilidad));
                //entonces no se ha usado esta disponibilidad, la usamos y tomamos
                //Guardo la Carga académica
                $newCargaAcad = new CargaAcademica();
                $newCargaAcad->fill([
                    'docente_id'=>$docente->id,
                    'asignatura_id'=>$asignatura->id,
                    'horario_id'=>$horario->id,
                    'sala_id'=>$sala->id
                ])->save();
                $disponibilidad = new Disponibilidad();
                $disponibilidad->fill([
                    'estado'=>'Ocupado',
                    'horario_id'=>$horario->id,
                    'sala_id'=>$sala->id
                ])->save();
                $tomado = new Tomado();
                $tomado->fill([
                    'disponibilidad_id'=>$disponibilidad->id,
                    'tomable_id'=>$newCargaAcad->id,
                    'tomable_type'=>CargaAcademica::class
                ])->save();
            }
        }
    }
}
