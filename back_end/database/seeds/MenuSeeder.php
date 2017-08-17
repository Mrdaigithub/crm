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
            'name' => '仪表盘',
            'url' => '/home/dashboard',
            'icon' => 'el-icon-ali-dashboard',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '3',
            'parent_id' => '1',
            'lft' => '4',
            'rgt' => '5',
            'depth' => '1',
            'name' => '排行',
            'url' => '/home/rank',
            'icon' => 'el-icon-ali-rank',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '4',
            'parent_id' => '1',
            'lft' => '6',
            'rgt' => '7',
            'depth' => '1',
            'name' => '客户列表',
            'url' => '/home/patients',
            'icon' => 'el-icon-ali-patients',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '5',
            'parent_id' => '1',
            'lft' => '8',
            'rgt' => '9',
            'depth' => '1',
            'name' => '用户列表',
            'url' => '/home/users',
            'icon' => 'el-icon-ali-users',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '6',
            'parent_id' => '1',
            'lft' => '10',
            'rgt' => '23',
            'depth' => '1',
            'name' => '数据中心',
            'icon' => 'el-icon-ali-data',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '7',
            'parent_id' => '6',
            'lft' => '11',
            'rgt' => '12',
            'depth' => '2',
            'name' => '总体数据',
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
            'name' => '用户数据',
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
            'name' => '病种数据',
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
            'name' => '渠道数据',
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
            'name' => '医生数据',
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
            'name' => '客户数据',
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
            'name' => '信息管理',
            'icon' => 'el-icon-ali-project',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '14',
            'parent_id' => '13',
            'lft' => '25',
            'rgt' => '26',
            'depth' => '2',
            'name' => '病种管理',
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
            'name' => '医生管理',
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
            'name' => '渠道管理',
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
            'name' => '咨询方式管理',
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
            'name' => '系统设置',
            'icon' => 'el-icon-ali-lock',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('menus')->insert([
            'id' => '19',
            'parent_id' => '18',
            'lft' => '35',
            'rgt' => '36',
            'depth' => '2',
            'name' => '行为日志',
            'url' => '/home/setting/log',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
