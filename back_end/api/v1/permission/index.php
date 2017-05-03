<?php

include '../../../core/core.php';

if (!$permission->has_permission('system_permission')) error_handler(48001);
if (!array_key_exists('role_name',$_GET)) error_handler(44001);

//获取权限组所拥有的权限
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $role_permission = $sql->query("SELECT permission FROM role WHERE name='".$_GET['role_name']."'");
    $role_permission = $role_permission[0]['permission'];
    $permission_json = array();
    for ($i = 0; $i < strlen($role_permission); $i++) {
        $role_permission;
        $p_title = $sql->query("SELECT title FROM permission WHERE id=$i+1");
        $p_title = $p_title[0]['title'];
        $p_json = array(
            'title' => $p_title,
            'expand' => true
        );
        if ($role_permission[$i] === '1') $p_json['checked'] = true;
        else $p_json['checked'] = false;
        array_push($permission_json, $p_json);
    }
    print_r(json_encode($permission_json));
    exit();
}

//更新某个权限值
if ($_SERVER['REQUEST_METHOD'] === 'PATCH'){
    print_r('patch');
    exit();
}



error_handler(43003);
