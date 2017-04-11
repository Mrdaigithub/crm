<?php

include '../../../core/core.php';

//获取用户对应的菜单数据
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    //缺少token参数
    if (!array_key_exists('token', $_GET)) error_handler(41001);

    $username = $jwt->verifyToken($_GET['token']);
    $power = $sql->query("SELECT power FROM admin WHERE username='" . $username . "';");
    $power = $power[0]['power'];
    $menuData = $sql->query("SELECT id,title,name,url FROM menu WHERE power<=" . $power . ";");
    $menuJson = $rootMenus = $subMenus = array();
    foreach ($menuData as $item) {
        if (strlen($item['name']) === 1) {
            array_push($menuJson, array(
                'title' => $item['title'],
                'name' => $item['name'],
                'url' => $item['url'],
                'child' => array()
            ));
        }
    }
    foreach ($menuData as $item) {
        if (preg_match('/\d-\d+/', $item['name'])) {
            $rootName = $item['name'][0];
            for ($i=0; $i<count($menuJson); $i++){
                if ($menuJson[$i]['name'] === $rootName){
                    array_push($menuJson[$i]['child'], $item);
                }
            }
        }
    }
    echo json_encode(array('menu_data'=>$menuJson));
    exit();
}
