<?php

namespace App\Console\Commands;

use App\Dia;
use App\Disponibilidad;
use App\Horario;
use App\Sala;
use Illuminate\Console\Command;

class HabilitarDiaCompleto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dia:activa
        {dia? : especifica el dia de la semana a afectar (desde 1 a 7), si no es especifica procesa el dia de ayer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando activa todas las salas deshabilitadas en un dia especifico';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $dia = $this->argument('dia');
        if(is_null($dia)){
            $detalle = 'ayer';
            $ayer = strtotime('-1 day');
            $dia = date('N',$ayer);
        }
        else{
            $nombre = Dia::where('id',$dia)->first()->es;
            $detalle = 'el dia '.$nombre;
        }

        $salas = Sala::all();
        $horarios = Horario::where('dia_id',$dia)->get();

        $contar = 0;
        foreach($horarios as $horario){
            foreach($salas as $sala){
                $disponibilidad = Disponibilidad::where('horario_id',$horario->id)
                    ->where('sala_id',$sala->id)->first();
                if(is_null($disponibilidad)){
                    //debo crearla, no existe
                    $disponibilidad = new Disponibilidad();
                    $disponibilidad->estado = 'Disponible';
                    $disponibilidad->sala()->associate($sala);
                    $disponibilidad->horario()->associate($horario);
                    $disponibilidad->save();
                    $contar++;
                }
                else{
                    //si existe, reviso su estado
                    if(is_null($disponibilidad->tomado_actual()) and $disponibilidad->estado='Deshabilitado'){
                        $disponibilidad->estado = 'Disponible';
                        $disponibilidad->save();
                        $contar++;
                    }
                }
            }
        }


        $this->info($contar.' horarios que estaban deshabilitados para '.$detalle.' ('.$dia.') se han disponibles');
    }
}
