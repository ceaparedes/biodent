<?php

use Illuminate\Database\Seeder;

class add_usuarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'com_id' => 156,
            'usu_rut' => 18135966,
            'usu_dv' => '8',
            'usu_nombres' => 'Víctor',
            'usu_apellido_paterno' => 'Cea',
            'usu_apellido_materno' => 'Paredes',
            'usu_fecha_nacimiento' => '1992-12-06',
            'usu_email' => 'viceaparedes@gmail.com',
            'usu_telefono' => 990886006,
            'usu_direccion' => 'Pasaje Laraquete #194, Villa los Heroes',
            'usu_usuario' => 'vicea',
            'usu_password' => bcrypt('vicea'),
            'usu_rol' => 'Administrador'
        ]);

        DB::table('usuarios')->insert([
            'com_id' => 156,
            'usu_rut' => 17640690,
            'usu_dv' => '9',
            'usu_nombres' => 'Pamela',
            'usu_apellido_paterno' => 'Cea',
            'usu_apellido_materno' => 'Paredes',
            'usu_fecha_nacimiento' => '1990-06-26',
            'usu_email' => 'pamelacea@gmail.com',
            'usu_telefono' => 990886006,
            'usu_direccion' => 'Pasaje Laraquete #194, Villa los Heroes',
            'usu_usuario' => 'pamelacea',
            'usu_password' => bcrypt('pamelacea'),
            'usu_rol' => 'Odontologo'
        ]);

        DB::table('usuarios')->insert([
            'com_id' => 156,
            'usu_rut' => 8174570,
            'usu_dv' => '6',
            'usu_nombres' => 'Armando',
            'usu_apellido_paterno' => 'Casas',
            'usu_apellido_materno' => 'Paredes',
            'usu_fecha_nacimiento' => '1990-06-26',
            'usu_email' => 'acasas@gmail.com',
            'usu_telefono' => 990886006,
            'usu_direccion' => 'Pasaje Laraquete #194, Villa los Heroes',
            'usu_usuario' => 'acasas',
            'usu_password' => bcrypt('acasas'),
            'usu_rol' => 'Asistente'
        ]);
    }
}
