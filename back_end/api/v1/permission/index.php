<?php

include '../../../core/core.php';

if (!$permission->has_permission('system_role')) error_handler(48001);

//获取单个权限组所拥有的权限
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!array_key_exists('role_name', $_GET)) error_handler(44001);
    $role_permission = $sql->query("SELECT permission FROM role WHERE role_name='" . $_GET['role_name'] . "'");
    $role_permission = $role_permission[0]['permission'];
    $permission_json = array();
    for ($i = 0; $i < strlen($role_permission); $i++) {
        $role_permission;
        $p = $sql->query("SELECT id, name, des FROM permission WHERE id=$i+1");
        $p_id = $p[0]['id'];
        $p_name = $p[0]['name'];
        $p_des = $p[0]['des'];
        $p_json = array(
            'id' => $p_id,
            'name'=> $p_name,
            'des' => $p_des
        );
        if ($role_permission[$i] === '1') $p_json['checked'] = true;
        else $p_json['active'] = false;
        array_push($permission_json, $p_json);
    }
    print_r(json_encode($permission_json));
    exit();
}

//更新role权限值
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('role_name', $req_args) || !array_key_exists('role_permission', $req_args)) error_handler(44001);
    $role_permission = $req_args['role_permission'];
    $role_permission_len = $sql->query("SELECT count('id') FROM permission");
    $role_permission_len = $role_permission_len[0]["count('id')"];
    if (strlen($role_permission) < $role_permission_len) $role_permission = str_pad($role_permission, $role_permission_len, '0');
    $sql->exec("UPDATE role SET permission='$role_permission' WHERE role_name='" . $req_args['role_name'] . "'");
    print_r(json_encode(array('role_permission' => $role_permission)));
    exit();
}

error_handler(43003);
