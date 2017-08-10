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
        Model::unguard();
        
         $this->call(UsersSeeder::class);
         $this->call(RolesSeeder::class);
         $this->call(Role_userSeede::class);
         $this->call(PermissionsSeeder::class);
         $this->call(Permission_roleSeede::class);
         $this->call(MenuSeeder::class);
         $this->call(ManagementSeeder::class);
         $this->call(PatientsSeeder::class);
        Model::reguard();
    }
}
