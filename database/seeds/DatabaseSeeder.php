<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(NotificationCategorySeeder::class);

        $roleAdm=\App\Role::where('name','administrador')->first();//le asigno el roll de empleado por defecto
        $user=\App\User::where('name','Admin')->first();
        $user->roles()->attach($roleAdm);
    }
}
