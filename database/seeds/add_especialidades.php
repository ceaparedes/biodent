<?php

use Illuminate\Database\Seeder;

class add_especialidades extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('especialidades')->insert([
            'esp_nombre' => 'Endodoncista',

        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Ortodoncista',

        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Rehabilitador Oral',

        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Implantologo',
        ]);

         DB::table('especialidades')->insert([
            'esp_nombre' => 'Odontopediatra',

        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Cirujano Máxilo Facial',
        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Radiólogo Máxilo Facial',
        ]);

        DB::table('especialidades')->insert([
            'esp_nombre' => 'Estética Facial',
        ]);


  
    }
}
