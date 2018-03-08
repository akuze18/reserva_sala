<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CarreraTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(PermisosTableSeeder::class);
        $this->call(EdificioTableSeeder::class);
        $this->call(PisoTableSeeder::class);
        $this->call(SalaTableSeeder::class);
        $this->call(NivelTableSeeder::class);
        $this->call(AsignaturaTableSeeder::class);
        $this->call(DiasTableSeeder::class);
        $this->call(ModuloTableSeeder::class);
        $this->call(MotivoTableSeeder::class);
        $this->call(HorarioTableSeeder::class);
        $this->call(CargaAcademicaTableSeeder::class);
        $this->call(SolicitudTableSeeder::class);
        $this->call(DisponibilidadTableSeeder::class);
    }
}
