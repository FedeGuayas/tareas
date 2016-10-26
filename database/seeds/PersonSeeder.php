<?php

use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Person::class,30)->create();
//            ->each(function($p){
//            $p->area()->save(factory(App\Area::class)->make());
//        });

//        factory(App\User::class, 50)->create()->each(function($u) {
//            $u->posts()->save(factory(App\Post::class)->make());
//        });
    }
}
