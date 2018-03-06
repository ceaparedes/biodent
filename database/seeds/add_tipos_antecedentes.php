<?php

use Illuminate\Database\Seeder;

class add_tipos_antecedentes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('tipos_antecedentes')->insert([
            'tan_tipo' => 'Enfermedades',

        ]);
       DB::table('tipos_antecedentes')->insert([
            'tan_tipo' => 'Alergias',

        ]);
       DB::table('tipos_antecedentes')->insert([
            'tan_tipo' => 'Medicamentos',

        ]);
       DB::table('tipos_antecedentes')->insert([
            'tan_tipo' => 'Otros',

        ]);
    }
}
