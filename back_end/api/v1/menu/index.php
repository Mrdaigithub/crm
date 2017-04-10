<?php

include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!array_key_exists('token', $_GET)) error_handler(41001); //需要GET请求
    $username = $jwt->verifyToken($_GET['token']);
    $p = $sql->query("SELECT power FROM admin WHERE username='" . $username . "';");
    $power = $p[0]['power'];
    $m = $sql->query("SELECT id,title,name,url,sub_menu FROM menu WHERE power<=" . $power . ";");
    $jsonData = $rootMenus = $subMenus = array();
    foreach ($m as $item) {
        if (strlen($item['name']) === 1) {
            array_push($jsonData, array(
                'title' => $item['title'],
                'name' => $item['name'],
                'child' => array()
            ));
        }
    }
    foreach ($m as $item) {
        if (preg_match('/\d-\d+/',$item['name'])){
            $rootName = $item['name'][0];
            foreach ($jsonData as $i){
                if ($i['name'] === $rootName){
                    array_push($i['child'],$item);
                }
            }
        }
    }
    print_r($jsonData);
    exit();
}

error_handler(43001);

//{
//    title:'导航一',
//    name:'1',
//    child:[
//        {title:'选项 1', name:'1-1'},
//        {title:'选项 2', name:'1-2'},
//        {title:'选项 3', name:'1-3'}
//    ]
//}