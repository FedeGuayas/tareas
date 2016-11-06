<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'administrador',
            'display_name'=>'Administrador',
            'description'=>'Administrador del sistema',
        ]);
        DB::table('roles')->insert([
            'name'=>'supervisor',
            'display_name'=>'Supervisor',
            'description'=>'Administra las tareas del sistema',
        ]);
        DB::table('roles')->insert([
            'name'=>'empleado',
            'display_name'=>'Trabajador',
            'description'=>'Trabajadors registrados a los k se les asignan las tareas',
        ]);
    }
}
