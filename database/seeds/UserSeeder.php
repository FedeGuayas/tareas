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
            'area_id'=>null,
            'name'=>'Admin',
            'first_name'=>'Hector',
            'last_name'=>'Alvarez',
            'phone'=>'0999873030',
            'email' => 'admin@mail.com',
            'password' => bcrypt('admin123'),
            'activated'=>true,
        ]);

       
        factory(App\User::class,20)->create();
        
    }
}
