<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'id' => 1,
            'name' => 'dashboard',
            'description' => '仪表盘',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 2,
            'name' => 'rank',
            'description' => '排行',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 3,
            'name' => 'patients',
            'description' => '客户列表',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 4,
            'name' => 'allow_patients_module',
            'description' => '允许使用客户列表模块',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 5,
            'name' => 'patients/info/get',
            'description' => '允许查看登记信息',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 6,
            'name' => 'patients/oth/info/get',
            'description' => '允许查看TA人登记信息',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 7,
            'name' => 'patients/full_tel/get',
            'description' => '允许查看修改客户完整电话',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 8,
            'name' => 'patients/oth/info/add',
            'description' => '允许使用TA人名义登记',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 9,
            'name' => 'patients/oth/info/edit',
            'description' => '允许编辑TA人登记信息',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 10,
            'name' => 'patients/arrive_state/edit',
            'description' => '允许确认已到状态',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 11,
            'name' => 'patients/state/edit',
            'description' => '允许更改除确认外状态',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 12,
            'name' => 'patients/price/edit',
            'description' => '允许修改补充客户消费情况',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 13,
            'name' => 'patients/advisory_date/edit',
            'description' => '允许修改客户预约日期',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 14,
            'name' => 'patients/channel/edit',
            'description' => '允许修改客户渠道来源',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 15,
            'name' => 'patients/advisory/edit',
            'description' => '允许修改客户咨询方式',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 16,
            'name' => 'patients/disease/edit',
            'description' => '允许修改客户预约病种',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 17,
            'name' => 'patients/doctor/edit',
            'description' => '允许修改客户预约医生',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 18,
            'name' => 'patients/wechat/edit',
            'description' => '允许修改客户QQ微信',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 19,
            'name' => 'patients/keyword/edit',
            'description' => '允许修改客户搜索关键词',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 20,
            'name' => 'patients/excel',
            'description' => '允许使用导出EXCEL功能',
            'parent_id' => 3,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 21,
            'name' => 'data',
            'description' => '数据中心',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 22,
            'name' => 'allow_data_module',
            'description' => '允许使用数据中心模块',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 23,
            'name' => 'data/total',
            'description' => '总体数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 24,
            'name' => 'data/user',
            'description' => '用户数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 25,
            'name' => 'data/disease',
            'description' => '病种数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 26,
            'name' => 'data/channel',
            'description' => '渠道数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 27,
            'name' => 'data/doctor',
            'description' => '医生数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 28,
            'name' => 'data/patient',
            'description' => '客户数据',
            'parent_id' => 21,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 29,
            'name' => 'info',
            'description' => '信息管理',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 30,
            'name' => 'allow_info_module',
            'description' => '允许使用信息管理模块',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 31,
            'name' => 'info/disease/add',
            'description' => '新增病种科室',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 32,
            'name' => 'info/disease/remove',
            'description' => '删除病种科室',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 33,
            'name' => 'info/disease/edit',
            'description' => '修改病种科室',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 34,
            'name' => 'info/doctor/add',
            'description' => '新增医生',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 35,
            'name' => 'info/doctor/remove',
            'description' => '删除医生',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 36,
            'name' => 'info/doctor/edit',
            'description' => '修改医生',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 37,
            'name' => 'info/channel/add',
            'description' => '新增来源渠道',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 38,
            'name' => 'info/channel/remove',
            'description' => '删除来源渠道',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 39,
            'name' => 'info/channel/edit',
            'description' => '修改来源渠道',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 40,
            'name' => 'info/advisory/add',
            'description' => '新增咨询方式',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 41,
            'name' => 'info/advisory/remove',
            'description' => '删除咨询方式',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 42,
            'name' => 'info/advisory/edit',
            'description' => '修改咨询方式',
            'parent_id' => 29,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 43,
            'name' => 'users',
            'description' => '人员管理',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 44,
            'name' => 'allow_users_module',
            'description' => '允许使用人员管理模块',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 45,
            'name' => 'users/role/add',
            'description' => '新增角色组',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 46,
            'name' => 'users/role/remove',
            'description' => '删除角色组',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 47,
            'name' => 'users/role/edit',
            'description' => '修改角色组',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 48,
            'name' => 'users/permission/edit',
            'description' => '修改角色组权限',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 49,
            'name' => 'users/user/add',
            'description' => '新增用户',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 50,
            'name' => 'users/user/remove',
            'description' => '删除用户',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 51,
            'name' => 'users/user/edit',
            'description' => '修改用户',
            'parent_id' => 43,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 52,
            'name' => 'setting',
            'description' => '系统管理',
            'depth' => 1,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 53,
            'name' => 'allow_setting_module',
            'description' => '允许使用系统管理模块',
            'parent_id' => 52,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => 54,
            'name' => 'setting/log',
            'description' => '查看日志记录',
            'parent_id' => 52,
            'depth' => 2,
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
