<?php

use Illuminate\Database\Seeder;


class NotificationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notification_categories')->insert([
            'name'=>'task.new',
            'text'=>'Nueva Tarea',
        ]);

        DB::table('notification_categories')->insert([
            'name'=>'task.end.sol',
            'text'=>'Solicitud finalización de tarea',
        ]);

        DB::table('notification_categories')->insert([
            'name'=>'tasks.end.aprob',
            'text'=>'Aprobada finalización de tarea',
        ]);
       
    }
}
