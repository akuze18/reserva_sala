<?php

use App\nivel;
use Illuminate\Database\Seeder;

class NivelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<=12;$i++){
            $nivel = new nivel();
            $nivel->fill(['name'=>$i.'º'])->save();
        }
    }
}
