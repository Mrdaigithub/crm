<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '1',
            'username' => 'root',
            'password' => bcrypt('root'),
            'tel' => '15956318235',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('users')->insert([
            'id' => 2,
            'username' => 'admin1',
            'password' => Hash::make('admin1'),
            'tel' => '15664192020',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('users')->insert([
            'id' => 3,
            'username' => 'admin2',
            'password' => Hash::make('admin2'),
            'tel' => '13637772694',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('users')->insert([
            'id' => 4,
            'username' => 'user1',
            'password' => Hash::make('user1'),
            'tel' => '13814674160',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('users')->insert([
            'id' => 5,
            'username' => 'user2',
            'password' => Hash::make('user2'),
            'tel' => '13643748991',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('users')->insert([
            'id' => 6,
            'username' => 'user3',
            'password' => Hash::make('user3'),
            'tel' => '15761479852',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
