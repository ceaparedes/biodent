<?php

use Illuminate\Database\Seeder;

class add_tratamientos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Endodoncia Anterior',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 70000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Endodoncia Premolar',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 80000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Endodoncia Molar',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 120000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Retratamiento Anterior',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 100000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Retratamiento Premolar',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 120000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Retratamiento Molar',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 150000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Trepanación de Urgencia',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 30000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Composite Simple',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 30000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Composite Compuesto',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 35000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Reconstitución',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 45000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Carilla',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 60000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Cementación Perno de Fibra',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 25000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Provisorio Acrílico',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 45000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Destrtartaje',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 30000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Profilaxis',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 20000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Sellante',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 10000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Fluoración + Profilaxis',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 45000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Exodoncia Simple',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 15000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Exodoncia 3º Molar Superior',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 50000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Exodoncia 3º Molar Inferior',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 70000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Implante Dental Unitario',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 650000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Injerto óseo',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 85000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Membrana',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 85000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Pulpotomía',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 45000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Pulpectomía',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 65000
        ]);

        DB::table('tratamientos')->insert([
            'tra_nombre' => 'Restauración Vidriolonómero',
            'tra_costo_laboratorio' => 0,
            'tra_costo' => 25000
        ]);
    }
}
