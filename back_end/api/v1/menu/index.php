<?php

include '../../../core/core.php';


//获取用户对应的菜单数据
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $menu_data = $sql->query("SELECT id,title,name,url FROM menu");
    $menu_json = array();

//    构建父菜单
    foreach ($menu_data as $item) {
        if (strlen($item['name']) === 1) {
            if (!$permission->has_permission('index/home') && $item['name'] === '1') continue; //无权查看控制台
            array_push($menu_json, array(
                'title' => $item['title'],
                'name' => $item['name'],
                'url' => $item['url'],
                'child' => array()
            ));
        }
    }

//    构建子菜单
    foreach ($menu_data as $item) {
//        if (preg_match('/\d-\d+/', $item['name'])) {
//            $rootName = $item['name'][0];
//            for ($i = 0; $i < count($menu_json); $i++) {
//                if ($menu_json[$i]['name'] === $rootName) {
//                    array_push($menu_json[$i]['child'], $item);
//                }
//            }
//        }
    }

//    if (!$permission->has_permission('index/home')) $menu_json = array_splice($menu_json,0,1);
//
//    if (!$permission->has_permission('patient')) array_splice($menu_json,1,1); //无权查看客户信息
//
//    if (!$permission->has_permission('data')) array_splice($menu_json,2,1); //无权查看数据报表
//    else{
//        if (!$permission->has_permission('t_report_data')) array_shift($menu_json[0]['child']); //无权查看绩效数据(文本)
//        if (!$permission->has_permission('c_report_data')) array_pop($menu_json[0]['child']); //无权查看绩效数据(图形)
//    }
//
//    if (!$permission->has_permission('info')) array_shift($menu_json); //无权查看信息管理

//    print_r($menu_json);
    exit();
}
error_handler(43003);
