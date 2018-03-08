<?php

namespace App\Console\Commands;

use App\Dia;
use App\Disponibilidad;
use App\Solicitud;
use Illuminate\Console\Command;

class LimpiarReservas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limpia:reservas {dia? : especifica el dia de la semana a afectar (desde 1 a 7), si no es especifica procesa el dia de ayer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'el sistema vuelva a habilitar las salas, que fueron solicitadas , una vez que termine el dia.';

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

        $disponibles = Disponibilidad::select('disponibilidades.*')
            ->join('horarios as H','H.id','=','disponibilidades.horario_id')
            ->where('disponibilidades.estado','Ocupado')
            ->where('H.dia_id',$dia)
            ->get();
        $contar = 0;
        foreach($disponibles as $disponibilidad){
            if(!is_null($disponibilidad->tomado_actual())){
                if(is_a($disponibilidad->tomado_actual()->tomable,Solicitud::class)){
                    $disponibilidad->estado = 'Deshabilitado';
                    $disponibilidad->save();
                    $tomado = $disponibilidad->tomado_actual();
                    $tomado->activo = false;
                    $tomado->save();
                    $contar++;
                }
            }
        }
        $this->info($contar.' horarios que fueron reservados para '.$detalle.' ('.$dia.') ya no estan tomados');
    }
}
