<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/13
 * Time: 19:06
 * Des: 获取指定权限组的权限详情
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$role_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要查询的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT * FROM admin_group WHERE id='$role_id'"))) error_handler(46008);

$role_permission = $GLOBALS['sql']->query("SELECT permission FROM admin_group WHERE id='$role_id'");
$role_permission = $role_permission[0]['permission'];
$permission_json = array();
for ($i = 0; $i < strlen($role_permission); $i++) {
    $role_permission;
    $p = $GLOBALS['sql']->query("SELECT id, name, permissino_des FROM permission WHERE id=$i+1");
    $p_id = $p[0]['id'];
    $p_name = $p[0]['name'];
    $p_des = $p[0]['des'];
    $p_json = array(
        'id' => $p_id,
        'name' => $p_name,
        'des' => $p_des
    );
    if ($role_permission[$i] === '1') $p_json['checked'] = true;
    else $p_json['active'] = false;
    array_push($permission_json, $p_json);
}
print_r(json_encode(array(
    'permission' => $permission_json
)));
exit();
