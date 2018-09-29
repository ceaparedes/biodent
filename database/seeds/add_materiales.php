<?php

use Illuminate\Database\Seeder;

class add_materiales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materiales')->insert([
            'mat_codigo' => '0101452',
            'mat_nombre_material' => 'TOPES SILICONA',
            'mat_costo' => '24',
            'mat_stock' => '50',
            'mat_stock_minimo' => '10',
            'mat_fecha_creacion' => '2018-09-09',
            'mat_estado' => 'Disponible',

        ]);

        DB::table('materiales')->insert([
            'mat_codigo' => '0104525',
            'mat_nombre_material' => 'CONO GUTTA-PERCHA PROTAPER',
            'mat_costo' => '11500',
            'mat_stock' => '10',
            'mat_stock_minimo' => '30',
            'mat_fecha_creacion' => '2018-09-09',
            'mat_estado' => 'Disponible',

        ]);

        DB::table('materiales')->insert([
            'mat_codigo' => '0104521',
            'mat_nombre_material' => 'LIMA H ACCESS 21MM',
            'mat_costo' => '800',
            'mat_stock' => '12',
            'mat_stock_minimo' => '4',
            'mat_fecha_creacion' => '2018-09-09',
            'mat_estado' => 'Disponible',

        ]);
    }
}
