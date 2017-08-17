<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Menu;
use JWTAuth, JWTException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    function __construct()
    {
        $this->u_self = JWTAuth::parseToken()->authenticate();
        $this->r_self = $this->u_self->roles[0];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::root()->descendants();
        if (!$this->r_self->hasPermission('dashboard')) $menu = $this->clear_menu_nodes('仪表盘', $menu);
        if (!$this->r_self->hasPermission('rank')) $menu = $this->clear_menu_nodes('排行', $menu);
        if (!$this->r_self->hasPermission('allow_patients_module')) $menu = $this->clear_menu_nodes('客户列表', $menu);
        if (!$this->r_self->hasPermission('allow_data_module')) {
            $menu = $this->clear_menu_nodes('数据中心', $menu);
        } else {
            if (!$this->r_self->hasPermission('data/total')) $menu = $this->clear_menu_nodes('总体数据', $menu);
            if (!$this->r_self->hasPermission('data/user')) $menu = $this->clear_menu_nodes('用户数据', $menu);
            if (!$this->r_self->hasPermission('data/disease')) $menu = $this->clear_menu_nodes('病种数据', $menu);
            if (!$this->r_self->hasPermission('data/channel')) $menu = $this->clear_menu_nodes('渠道数据', $menu);
            if (!$this->r_self->hasPermission('data/doctor')) $menu = $this->clear_menu_nodes('医生数据', $menu);
            if (!$this->r_self->hasPermission('data/patient')) $menu = $this->clear_menu_nodes('客户数据', $menu);
        }
        if (!$this->r_self->hasPermission('allow_info_module')) $menu = $this->clear_menu_nodes('信息管理', $menu);
        if (!$this->r_self->hasPermission('allow_users_module')) $menu = $this->clear_menu_nodes('用户列表', $menu);
        if (!$this->r_self->hasPermission('allow_setting_module')) $menu = $this->clear_menu_nodes('系统设置', $menu);
        $menu = $menu->get()->toHierarchy();
        return $menu;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $children = [
            ['name' => 'root', 'children' => [
                ['name' => 'Console', 'url' => '/home/console'],
                ['name' => 'Rank', 'url' => '/home/rank'],
                ['name' => 'Patients', 'url' => '/home/patients'],
                ['name' => 'Users list', 'url' => '/home/users'],
                ['name' => 'Data', 'children' => [
                    ['name' => 'Total data', 'url' => '/home/data/total'],
                    ['name' => 'Users data', 'url' => '/home/data/users'],
                    ['name' => 'Diseases data', 'url' => '/home/data/diseases'],
                    ['name' => 'Channels data', 'url' => '/home/data/channels'],
                    ['name' => 'Doctors data', 'url' => '/home/data/doctors'],
                    ['name' => 'Patients data', 'url' => '/home/data/patients']
                ]],
                ['name' => 'Project info', 'children' => [
                    ['name' => 'Diseases management', 'url' => '/home/management/diseases'],
                    ['name' => 'Doctor management', 'url' => '/home/management/doctors'],
                    ['name' => 'Channel management', 'url' => '/home/management/channel'],
                    ['name' => 'Advisory management', 'url' => '/home/management/advisory'],
                ]],
                ['name' => 'System setting', 'children' => [
                    ['name' => 'Parameter setting', 'url' => '/home/setting/parameter'],
                    ['name' => 'log', 'url' => '/home/setting/log']
                ]]
            ]]
        ];
        return response()->json(Menu::buildTree($children));
    }

    /**
     * 删除无权限访问的菜单节点
     *
     * @param $n_name
     * @param $menu
     * @return mixed
     */
    private function clear_menu_nodes($n_name, $menu)
    {
        $withoutNodes = Menu::where('name', $n_name)->first()->descendantsAndSelf()->get();
        $withoutNodes->each(function ($withoutNode) use ($menu) {
            $menu = $menu->withoutNode($withoutNode);
        });
        return $menu;
    }
}
