<?php

include '../../../core/core.php';

if (!$permission->has_permission('system_permission')) error_handler(48001);

//获取权限组所拥有的权限
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!array_key_exists('role_name', $_GET)) error_handler(44001);
    $role_permission = $sql->query("SELECT permission FROM role WHERE name='" . $_GET['role_name'] . "'");
    $role_permission = $role_permission[0]['permission'];
    $permission_json = array();
    for ($i = 0; $i < strlen($role_permission); $i++) {
        $role_permission;
        $p = $sql->query("SELECT id, title FROM permission WHERE id=$i+1");
        $p_id = $p[0]['id'];
        $p_title = $p[0]['title'];
        $p_json = array(
            'id' => $p_id,
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

//更新role权限值
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('role_name', $req_args) || !array_key_exists('role_permission', $req_args)) error_handler(44001);
    $role_permission = json_decode($req_args['role_permission']);
    $role_permission_val = '';
    $role_permission_len = "SELECT count('id') FROM permission";
    foreach ($role_permission as $item) {
        if ($item->checked) $role_permission_val .= '1';
        else $role_permission_val .= '0';
    }
    if (strlen($role_permission_val) < $role_permission_len) $role_permission_val = str_pad($role_permission_val, $role_permission_len, '0');
    $sql->exec("UPDATE role SET permission='$role_permission_val' WHERE name='" . $req_args['role_name'] . "'");
    print_r(json_encode(array('role_permission' => $role_permission_val)));
    exit();
}

error_handler(43003);
