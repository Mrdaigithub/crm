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
            'rgt' => '48',
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
            'url' => '/home/patient',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '5',
            'parent_id' => '1',
            'lft' => '8',
            'rgt' => '15',
            'depth' => '1',
            'name' => 'Patient track',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '6',
            'parent_id' => '5',
            'lft' => '9',
            'rgt' => '10',
            'depth' => '2',
            'name' => 'Patient track list',
            'url' => '/patient/track/list',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '7',
            'parent_id' => '5',
            'lft' => '11',
            'rgt' => '12',
            'depth' => '2',
            'name' => 'My track',
            'url' => '/patient/track/my',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '8',
            'parent_id' => '5',
            'lft' => '13',
            'rgt' => '14',
            'depth' => '2',
            'name' => 'Track task',
            'url' => '/patient/track/task',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '9',
            'parent_id' => '1',
            'lft' => '16',
            'rgt' => '27',
            'depth' => '1',
            'name' => 'Project info',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '10',
            'parent_id' => '9',
            'lft' => '17',
            'rgt' => '18',
            'depth' => '2',
            'name' => 'Hospital management',
            'url' => '/project/hospitals',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '11',
            'parent_id' => '9',
            'lft' => '19',
            'rgt' => '20',
            'depth' => '2',
            'name' => 'Diseases management',
            'url' => '/patient/diseases',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '12',
            'parent_id' => '9',
            'lft' => '21',
            'rgt' => '22',
            'depth' => '2',
            'name' => 'Doctor management',
            'url' => '/patient/doctors',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '13',
            'parent_id' => '9',
            'lft' => '23',
            'rgt' => '24',
            'depth' => '2',
            'name' => 'Channel management',
            'url' => '/patient/channel',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '14',
            'parent_id' => '9',
            'lft' => '25',
            'rgt' => '26',
            'depth' => '2',
            'name' => 'Advisory management',
            'url' => '/patient/advisory',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '15',
            'parent_id' => '1',
            'lft' => '28',
            'rgt' => '39',
            'depth' => '1',
            'name' => 'Data',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '16',
            'parent_id' => '15',
            'lft' => '29',
            'rgt' => '30',
            'depth' => '2',
            'name' => 'Map data',
            'url' => '/data/map',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '17',
            'parent_id' => '15',
            'lft' => '31',
            'rgt' => '32',
            'depth' => '2',
            'name' => 'Group data',
            'url' => '/data/group',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '18',
            'parent_id' => '15',
            'lft' => '33',
            'rgt' => '34',
            'depth' => '2',
            'name' => 'Doctor data',
            'url' => '/patient/doctors',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '19',
            'parent_id' => '15',
            'lft' => '35',
            'rgt' => '36',
            'depth' => '2',
            'name' => 'Performance data',
            'url' => '/patient/performance',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '20',
            'parent_id' => '15',
            'lft' => '37',
            'rgt' => '38',
            'depth' => '2',
            'name' => 'Report data',
            'url' => '/patient/report',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '21',
            'parent_id' => '1',
            'lft' => '40',
            'rgt' => '45',
            'depth' => '1',
            'name' => 'System setting',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '22',
            'parent_id' => '21',
            'lft' => '41',
            'rgt' => '42',
            'depth' => '2',
            'name' => 'Parameter setting',
            'url' => '/setting/parameter',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '23',
            'parent_id' => '21',
            'lft' => '43',
            'rgt' => '44',
            'depth' => '2',
            'name' => 'log',
            'url' => '/setting/log',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '24',
            'parent_id' => '1',
            'lft' => '46',
            'rgt' => '47',
            'depth' => '1',
            'name' => 'Users list',
            'url' => '/home/users',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
