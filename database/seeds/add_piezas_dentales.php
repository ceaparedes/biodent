<?php

use Illuminate\Database\Seeder;

class add_piezas_dentales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.1',
            'pde_nombre_pieza' => 'Incisivo Central Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.2',
            'pde_nombre_pieza' => 'Incisivo Lateral Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.3',
            'pde_nombre_pieza' => 'Canino Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.4',
            'pde_nombre_pieza' => 'Primer Premolar Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.5',
            'pde_nombre_pieza' => 'Segundo Premolar Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.6',
            'pde_nombre_pieza' => 'Primer Molar Superior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.7',
            'pde_nombre_pieza' => 'Segundo Molar Superio Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '1.8',
            'pde_nombre_pieza' => 'Tercer Molar Superio Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.1',
            'pde_nombre_pieza' => 'Incisivo Central Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.2',
            'pde_nombre_pieza' => 'Incisivo Lateral Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.3',
            'pde_nombre_pieza' => 'Canino Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.4',
            'pde_nombre_pieza' => 'Primer Premolar Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.5',
            'pde_nombre_pieza' => 'Segundo Premolar Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.6',
            'pde_nombre_pieza' => 'Primer Molar Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.7',
            'pde_nombre_pieza' => 'Segundo Molar Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '2.8',
            'pde_nombre_pieza' => 'Tercer Molar Superior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.1',
            'pde_nombre_pieza' => 'Incisivo central Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.2',
            'pde_nombre_pieza' => 'Incisivo Lateral Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.3',
            'pde_nombre_pieza' => 'Canino Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.4',
            'pde_nombre_pieza' => 'Primer Premolar Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.5',
            'pde_nombre_pieza' => 'Segundo Premolar Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.6',
            'pde_nombre_pieza' => 'Primer Molar Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.7',
            'pde_nombre_pieza' => 'Segundo Molar Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '3.8',
            'pde_nombre_pieza' => 'Tercer Molar Inferior Izquierdo',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.1',
            'pde_nombre_pieza' => 'Incisivo Central Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.2',
            'pde_nombre_pieza' => 'Incisivo Lateral Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.3',
            'pde_nombre_pieza' => 'Canino Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.4',
            'pde_nombre_pieza' => 'Primer Premolar Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.5',
            'pde_nombre_pieza' => 'Segundo Premolar Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.6',
            'pde_nombre_pieza' => 'Primer Molar Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.7',
            'pde_nombre_pieza' => 'Segundo Molar Inferior Derecho',
        ]);

        DB::table('piezas_dentales')->insert([
            'pde_codigo_pieza' => '4.8',
            'pde_nombre_pieza' => 'Tercer Molar Inferior Derecho',
        ]);

    }
}
