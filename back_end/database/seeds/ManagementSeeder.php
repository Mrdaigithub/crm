<?php

use Illuminate\Database\Seeder;

class ManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // diseases
        DB::table('diseases')->insert([
            'id' => 1,
            'lft' => 1,
            'rgt' => 12,
            'depth' => 0,
            'name' => 'root',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('diseases')->insert([
            'id' => 2,
            'parent_id' => 1,
            'lft' => 2,
            'rgt' => 5,
            'depth' => 1,
            'name' => 'disease1',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('diseases')->insert([
            'id' => 3,
            'parent_id' => 2,
            'lft' => 3,
            'rgt' => 4,
            'depth' => 2,
            'name' => 'disease1-1',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('diseases')->insert([
            'id' => 4,
            'parent_id' => 1,
            'lft' => 6,
            'rgt' => 11,
            'depth' => 1,
            'name' => 'disease2',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('diseases')->insert([
            'id' => 5,
            'parent_id' => 4,
            'lft' => 7,
            'rgt' => 8,
            'depth' => 2,
            'name' => 'disease2-1',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('diseases')->insert([
            'id' => 6,
            'parent_id' => 4,
            'lft' => 9,
            'rgt' => 10,
            'depth' => 2,
            'name' => 'disease2-2',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);

        // doctors
        DB::table('doctors')->insert([
            'id' => 1,
            'name' => 'doctors1',
            'state' => true,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('doctors')->insert([
            'id' => 2,
            'name' => 'doctors2',
            'state' => false,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('doctors')->insert([
            'id' => 3,
            'name' => 'doctors3',
            'state' => false,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);

        // channels
        DB::table('channels')->insert([
            'id' => 1,
            'name' => 'google',
            'state' => false,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('channels')->insert([
            'id' => 2,
            'name' => 'baidu',
            'state' => true,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('channels')->insert([
            'id' => 3,
            'name' => 'sougou',
            'state' => false,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);

        // advisories
        DB::table('advisories')->insert([
            'id' => 1,
            'name' => 'QQ',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('advisories')->insert([
            'id' => 2,
            'name' => 'Wechat',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('advisories')->insert([
            'id' => 3,
            'name' => 'swt',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
