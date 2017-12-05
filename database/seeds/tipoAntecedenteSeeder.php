<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class tipoAntecedenteSeeder extends Seeder
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
        	'tan_tipo' => 'Medicamentos',
        ]);

        DB::table('tipos_antecedentes')->insert([
        	'tan_tipo' => 'Alergias',
        ]);

        DB::table('tipos_antecedentes')->insert([
        	'tan_tipo' => 'Otros',
        ]);
    }
}
