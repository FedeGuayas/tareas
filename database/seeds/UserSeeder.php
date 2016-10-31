<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin'),
        ]);
//        factory(App\User::class,10)->create();
        
    }
}
