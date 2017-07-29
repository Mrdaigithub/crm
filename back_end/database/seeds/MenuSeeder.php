<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'id' => '1',
            'lft' => '1',
            'rgt' => '40',
            'depth' => '0',
            'name' => 'root',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '2',
            'parent_id' => '1',
            'lft' => '2',
            'rgt' => '3',
            'depth' => '1',
            'name' => 'Console',
            'url' => '/home/console',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '3',
            'parent_id' => '1',
            'lft' => '4',
            'rgt' => '5',
            'depth' => '1',
            'name' => 'Rank',
            'url' => '/home/rank',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '4',
            'parent_id' => '1',
            'lft' => '6',
            'rgt' => '7',
            'depth' => '1',
            'name' => 'Patients',
            'url' => '/home/patients',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '5',
            'parent_id' => '1',
            'lft' => '8',
            'rgt' => '9',
            'depth' => '1',
            'name' => 'Users list',
            'url' => '/home/users',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '6',
            'parent_id' => '1',
            'lft' => '10',
            'rgt' => '23',
            'depth' => '1',
            'name' => 'Data',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '7',
            'parent_id' => '6',
            'lft' => '11',
            'rgt' => '12',
            'depth' => '2',
            'name' => 'Total data',
            'url' => '/home/data/total',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '8',
            'parent_id' => '6',
            'lft' => '13',
            'rgt' => '14',
            'depth' => '2',
            'name' => 'Users data',
            'url' => '/home/data/users',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '9',
            'parent_id' => '6',
            'lft' => '15',
            'rgt' => '16',
            'depth' => '2',
            'name' => 'Diseases data',
            'url' => '/home/data/diseases',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '10',
            'parent_id' => '6',
            'lft' => '17',
            'rgt' => '18',
            'depth' => '2',
            'name' => 'Channels data',
            'url' => '/home/data/channels',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '11',
            'parent_id' => '6',
            'lft' => '19',
            'rgt' => '20',
            'depth' => '2',
            'name' => 'Doctors data',
            'url' => '/home/data/doctors',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '12',
            'parent_id' => '6',
            'lft' => '21',
            'rgt' => '22',
            'depth' => '2',
            'name' => 'Patients data',
            'url' => '/home/data/patients',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '13',
            'parent_id' => '1',
            'lft' => '24',
            'rgt' => '33',
            'depth' => '1',
            'name' => 'Project info',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '14',
            'parent_id' => '13',
            'lft' => '25',
            'rgt' => '26',
            'depth' => '2',
            'name' => 'Diseases management',
            'url' => '/home/management/diseases',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '15',
            'parent_id' => '13',
            'lft' => '27',
            'rgt' => '28',
            'depth' => '2',
            'name' => 'Doctor management',
            'url' => '/home/management/doctors',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '16',
            'parent_id' => '13',
            'lft' => '29',
            'rgt' => '30',
            'depth' => '2',
            'name' => 'Channel management',
            'url' => '/home/management/channels',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '17',
            'parent_id' => '13',
            'lft' => '31',
            'rgt' => '32',
            'depth' => '2',
            'name' => 'Advisory management',
            'url' => '/home/management/advisory',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '18',
            'parent_id' => '1',
            'lft' => '34',
            'rgt' => '39',
            'depth' => '1',
            'name' => 'System setting',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '19',
            'parent_id' => '18',
            'lft' => '35',
            'rgt' => '36',
            'depth' => '2',
            'name' => 'Parameter setting',
            'url' => '/home/setting/parameter',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '20',
            'parent_id' => '18',
            'lft' => '37',
            'rgt' => '38',
            'depth' => '2',
            'name' => 'Log',
            'url' => '/home/setting/log',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
