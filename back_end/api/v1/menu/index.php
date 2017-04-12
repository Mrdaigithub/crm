<?php

include '../../../core/core.php';

//获取用户对应的菜单数据
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //缺少token参数
    if (!array_key_exists('token', $_GET)) error_handler(41001);

    $username = $jwt->verifyToken($_GET['token']);
    $power = $sql->query("SELECT power FROM admin WHERE username='" . $username . "';");
    $power = $power[0]['power'];
    $menu_data = $sql->query("SELECT id,title,name,url FROM menu WHERE power<=" . $power . ";");
    $menu_json = array();
    foreach ($menu_data as $item) {
        if (strlen($item['name']) === 1) {
            array_push($menu_json, array(
                'title' => $item['title'],
                'name' => $item['name'],
                'url' => $item['url'],
                'child' => array()
            ));
        }
    }
    foreach ($menu_data as $item) {
        if (preg_match('/\d-\d+/', $item['name'])) {
            $rootName = $item['name'][0];
            for ($i=0; $i<count($menu_json); $i++){
                if ($menu_json[$i]['name'] === $rootName){
                    array_push($menu_json[$i]['child'], $item);
                }
            }
        }
    }
    echo json_encode(array('menu_data'=>$menu_json));
    exit();
}
