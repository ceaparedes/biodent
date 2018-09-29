<?php

use Illuminate\Database\Seeder;

class add_estados_planes_de_tratamientos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('estados_planes_de_tratamientos')->insert([
            'ept_estado' => 'Plan de Tratamiento Creado',
        ]);

       DB::table('estados_planes_de_tratamientos')->insert([
            'ept_estado' => 'Plan de Tratamiento Iniciado',
        ]);

       DB::table('estados_planes_de_tratamientos')->insert([
            'ept_estado' => 'Plan de Tratamiento Completado',
        ]);

       DB::table('estados_planes_de_tratamientos')->insert([
            'ept_estado' => 'Plan de Tratamiento Cancelado por el Usuario',
        ]);

       DB::table('estados_planes_de_tratamientos')->insert([
            'ept_estado' => 'Plan de Tratamiento Finalizado',
        ]);


    }
}
