<?php

use App\Edificio;
use Illuminate\Database\Seeder;

class EdificioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Edificio::create(['name'=>'A']);
        Edificio::create(['name'=>'B']);
        Edificio::create(['name'=>'C']);
        Edificio::create(['name'=>'D']);
    }
}
