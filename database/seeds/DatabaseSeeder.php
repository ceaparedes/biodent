<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->call(add_comuna::class);
        $this->call(add_especialidades::class);
        $this->call(add_estados_planes_de_tratamientos::class);
        $this->call(add_piezas_dentales::class);
        $this->call(add_tipos_antecedentes::class);
        $this->call(add_tratamientos::class);
        $this->call(add_usuarios::class);
        $this->call(add_materiales::class);
    }
}
