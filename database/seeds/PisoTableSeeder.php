<?php

use App\Edificio;
use App\Piso;
use Illuminate\Database\Seeder;

class PisoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setup = [
            ['name'=>'A','cant'=>4],
            ['name'=>'B','cant'=>4],
            ['name'=>'C','cant'=>3],
            ['name'=>'D','cant'=>1],
        ];
        foreach($setup as $single){
            $edificio = Edificio::where('name',$single['name'])->first();
            for($i=1;$i<=$single['cant'];$i++){
                $piso = Piso::create([
                    'name'=>$i,
                    'edificio_id'=>$edificio->id
                ]);
            }
        }

    }
}
