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
            'id' => '1',
            'name' => 'dashboard',
            'description' => '控制面板',
            'depth' => '0',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '2',
            'name' => 'rank',
            'depth' => '0',
            'description' => '排行',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '3',
            'name' => 'patient',
            'description' => '信息列表',
            'depth' => '0',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '5',
            'name' => 'huif_info',
            'description' => '允许回访客户',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '6',
            'name' => 'huif_oth',
            'description' => '允许回访TA人客户',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '7',
            'name' => 'show_info',
            'description' => '允许查看客户信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '8',
            'name' => 'show_oth',
            'description' => '允许查看TA人登记信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '9',
            'name' => 'show_tel',
            'description' => '允许查看客户完整电话',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '10',
            'name' => 'checkinfo',
            'description' => '允许确认已到状态',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '11',
            'name' => 'status_oth',
            'description' => '允许更改除确认外状态',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '12',
            'name' => 'ok_doc',
            'description' => '允许设置客户接诊医生',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '13',
            'name' => 'add_info',
            'description' => '允许新增客户信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '14',
            'name' => 'edit_info',
            'description' => '允许编辑客户信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '15',
            'name' => 'edit_oth',
            'description' => '允许编辑TA人登记信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '16',
            'name' => 'Admin/List/toexcel',
            'description' => '允许使用导出EXCEL功能',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '17',
            'name' => 'Admin/Posts/edit_info',
            'description' => '客户信息编辑查看操作',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '18',
            'name' => 'edit_name',
            'description' => '允许修改客户姓名/年龄/性别',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '19',
            'name' => 'edit_money',
            'description' => '允许修改补充客户消费情况',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '20',
            'name' => 'edit_pubdate',
            'description' => '允许修改客户预约日期',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '21',
            'name' => 'edit_tel',
            'description' => '允许修改客户联系电话',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '22',
            'name' => 'edit_content',
            'description' => '允许修改客户预约备注',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '23',
            'name' => 'edit_flag',
            'description' => '允许修改客户渠道来源',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '24',
            'name' => 'edit_zxfs',
            'description' => '允许修改客户咨询方式',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '25',
            'name' => 'edit_dise',
            'description' => '允许修改客户预约病种',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '26',
            'name' => 'edit_doc',
            'description' => '允许修改客户预约医生',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '27',
            'name' => 'edit_tencent',
            'description' => '允许修改客户QQ微信',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '28',
            'name' => 'edit_area',
            'description' => '允许修改客户所在地址',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '29',
            'name' => 'edit_url',
            'description' => '允许修改客户来源网站',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '30',
            'name' => 'edit_lurl',
            'description' => '允许修改客户来源页面',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '31',
            'name' => 'edit_okurl',
            'description' => '允许修改客户转化页面',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '32',
            'name' => 'edit_key',
            'description' => '允许修改客户搜索关键词',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '33',
            'name' => 'edit_body',
            'description' => '允许修改客户对话信息',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '34',
            'name' => 'edit_okdate',
            'description' => '允许修改客户确认时间',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '35',
            'name' => 'Admin/ShowNav/Data',
            'description' => '数据中心',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '36',
            'name' => 'Admin/Data/echart',
            'description' => '图形数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '37',
            'name' => 'Admin/Data/group',
            'description' => '分组数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '38',
            'name' => 'Admin/Data/group_mid',
            'description' => '客服数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '39',
            'name' => 'Admin/Data/group_disease',
            'description' => '病种数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '40',
            'name' => 'Admin/Data/group_flag',
            'description' => '渠道数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '41',
            'name' => 'Admin/Data/group_city',
            'description' => '区域数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '42',
            'name' => 'Admin/Report/index',
            'description' => '绩效数据(文本)',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '43',
            'name' => 'Admin/Report/rp_kf',
            'description' => '客服数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '44',
            'name' => 'Admin/Report/rp_disease',
            'description' => '病种数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '45',
            'name' => 'Admin/Report/rp_media',
            'description' => '渠道数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '46',
            'name' => 'Admin/Report/rp_doctor',
            'description' => '医生数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '47',
            'name' => 'Admin/Report/rp_status',
            'description' => '状态数据',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
//        DB::table('permissions')->insert([
//            'id' => '48',
//            'name' => 'Admin/Data/group_flag',
//            'description' => '渠道数据',
//            'created_at' => date('Y-m-d h:m:s'),
//            'updated_at' => date('Y-m-d h:m:s')
//        ]);
        DB::table('permissions')->insert([
            'id' => '49',
            'name' => 'Admin/Reports/index',
            'description' => '绩效视图(图形)',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '50',
            'name' => 'Admin/Reports/rp_kf',
            'description' => '客服视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '51',
            'name' => 'Admin/Reports/rp_disease',
            'description' => '病种视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '52',
            'name' => 'Admin/Reports/rp_media',
            'description' => '渠道视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '53',
            'name' => 'Admin/Reports/rp_doctor',
            'description' => '医生视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '54',
            'name' => 'Admin/Reports/rp_status',
            'description' => '状态视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '55',
            'name' => 'Admin/Reports/rp_type',
            'description' => '医院视图',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '56',
            'name' => 'Admin/Public/ShowNav',
            'description' => '附加功能',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '57',
            'name' => 'Admin/User/me',
            'description' => '个人中心',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '58',
            'name' => 'Admin/User/upload_img',
            'description' => '允许上传头像',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '59',
            'name' => 'task',
            'description' => '任务',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '60',
            'name' => 'task_list',
            'description' => '访问任务清单权限',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '61',
            'name' => 'task_ok',
            'description' => '访问已分配清单权限',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '62',
            'name' => 'task_assigns',
            'description' => '分配任务权限',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '63',
            'name' => 'Admin/ShowNav/info',
            'description' => '信息管理',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '64',
            'name' => 'Admin/Disease/index',
            'description' => '病种科室',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '65',
            'name' => 'Admin/Disease/add_disease',
            'description' => '新增病种科室',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '66',
            'name' => 'Admin/Disease/delete',
            'description' => '删除病种科室',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '67',
            'name' => 'Admin/Doctor/index',
            'description' => '医生管理',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '68',
            'name' => 'Admin/Doctor/add_doctor',
            'description' => '新增医生',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '69',
            'name' => 'Admin/Doctor/delete',
            'description' => '删除医生',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '70',
            'name' => 'Admin/Doctor/edit_doctor',
            'description' => '编辑医生详情',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '71',
            'name' => 'Admin/Flag/index',
            'description' => '来源渠道',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '72',
            'name' => 'Admin/Flag/add_flag',
            'description' => '新增来源渠道',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '73',
            'name' => 'Admin/Flag/delete',
            'description' => '删除来源渠道',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '74',
            'name' => 'Admin/Zxtype/index',
            'description' => '咨询方式',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '75',
            'name' => 'Admin/Zxtype/add_zxfs',
            'description' => '新增咨询方式',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
        DB::table('permissions')->insert([
            'id' => '76',
            'name' => 'Admin/Zxtype/delete',
            'description' => '删除咨询方式',
            'created_at' => date('Y-m-d h:m:s'),
            'updated_at' => date('Y-m-d h:m:s')
        ]);
    }
}
