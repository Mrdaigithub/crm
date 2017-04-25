<?php

include '../../../core/core.php';


//获取用户对应的菜单数据
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $permission->has_permission('patient');


////    $power = $sql->query("SELECT power FROM users WHERE username='" . $username . "';");
//    $permission_data = $sql->query("SELECT permission FROM role WHERE id=(SELECT id FROM users WHERE username='$username');");
//    $permission_data = $permission_data[0]['permission'];
//
////    $power = $power[0]['power'];
//    $menu_data = $sql->query("SELECT id,title,name,url FROM menu");
//    $menu_json = array();
//    foreach ($menu_data as $item) {
//        if (strlen($item['name']) === 1) {
//            array_push($menu_json, array(
//                'title' => $item['title'],
//                'name' => $item['name'],
//                'url' => $item['url'],
//                'child' => array()
//            ));
//        }
//    }
//    foreach ($menu_data as $item) {
//        if (preg_match('/\d-\d+/', $item['name'])) {
//            $rootName = $item['name'][0];
//            for ($i = 0; $i < count($menu_json); $i++) {
//                if ($menu_json[$i]['name'] === $rootName) {
//                    array_push($menu_json[$i]['child'], $item);
//                }
//            }
//        }
//    }


////    无权查看控制台
//    if ($permission[1] === '0') array_shift($menu_json);
//
////    无权查看客户信息
//    if ($permission[3] === '0') array_shift($menu_json);
//
////    无权查看数据报表
//    if ($permission[46] === '0') array_shift($menu_json);
//    else{
////        无权查看绩效数据(文本)
//        if ($permission[51] === '0') array_shift($menu_json[0]['child']);
////        无权查看绩效数据(图形)
//        if ($permission[55] === '0') array_pop($menu_json[0]['child']);
//    }
//
////    无权查看信息管理
//    if ($permission[29] === '0') array_shift($menu_json);
//    else{
////        无权查看信息管理
//        if ($permission[30] === '0') array_shift($menu_json);
//    }
//    print_r($menu_json);
//    echo json_encode(array('menu_data'=>$menu_json));
    exit();
}
error_handler(43003);
