<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name'=>'create-area',
            'display_name'=>'Gesionar las areas',
            'description'=>'Crea edita y elimina las areas',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit-area',
            'display_name'=>'Editar el area',
            'description'=>'Crea edita y elimina las areas',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete-area',
            'display_name'=>'Eliminar el area',
            'description'=>'Crea edita y elimina las areas',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create-user',
            'display_name'=>'Crea usuarios',
            'description'=>'Crear trabajadores',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit-user',
            'display_name'=>'Editar usuarios',
            'description'=>'Edita trabajadores',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete-user',
            'display_name'=>'Elimina usuarios',
            'description'=>'Eliminar trabajadores',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create-task',
            'display_name'=>'Crear tareas',
            'description'=>'Crea tareas en el sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit-task',
            'display_name'=>'Editar tareas',
            'description'=>'Edita tareas en el sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete-task',
            'display_name'=>'Elimina tareas',
            'description'=>'Elimina tareas en el sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'create-comment',
            'display_name'=>'Comentar tareas',
            'description'=>'Comenta las tareas del sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'edit-comment',
            'display_name'=>'Edita los comentarios',
            'description'=>'Edita comentarios de las tareas del sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'delete-comment',
            'display_name'=>'Elimina comentarios',
            'description'=>'Elimina comentarios de las tareas del sistema',
        ]);
        DB::table('permissions')->insert([
            'name'=>'aprobar-solicitud',
            'display_name'=>'Aprobar fin de tareas',
            'description'=>'Aprueba la finalizacion de una tarea',
        ]);
    }
}
