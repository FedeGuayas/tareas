<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Area::class, 10)->create();

//        //Solo si el numero de personas es el mismo que de areas sino da error
//        factory(App\Area::class, 10)->create()->each(function ($area) {
//            factory(App\Person::class)->create(['area_id' => $area->id]);
//        });
        
    } 
}
