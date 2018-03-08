<?php

use App\Modulo;
use Illuminate\Database\Seeder;

class ModuloTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 08:30:00'));
        for($i=1;$i<=18;$i++){
            $date_final = date('Y-m-d H:i',strtotime($date_inicial.' + 45 minutes'));
            Modulo::create([
                'name'=>$i,
                'hora_inicio'=>$date_inicial,
                'hora_fin'=>$date_final
            ]);
            $date_inicial=$date_final;
            //$excepcion1 = date('Y-m-d H:i',strtotime('01/01/2000 0:45'));
            if($date_inicial==date('Y-m-d H:i',strtotime('01/01/2000 10:45'))){
                $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 11:00'));
            }
            if($date_inicial==date('Y-m-d H:i',strtotime('01/01/2000 13:15'))){
                $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 13:30'));
            }
            if($date_inicial==date('Y-m-d H:i',strtotime('01/01/2000 15:45'))){
                $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 16:00'));
            }
            if($date_inicial==date('Y-m-d H:i',strtotime('01/01/2000 18:15'))){
                $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 18:50'));
            }
            if($date_inicial==date('Y-m-d H:i',strtotime('01/01/2000 21:05'))){
                $date_inicial = date('Y-m-d H:i',strtotime('01/01/2000 21:15'));
            }
        }
    }
}
