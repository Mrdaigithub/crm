<?php
/**
 * Created by PhpStorm.
 * User: 34613
 * Date: 2017/5/13
 * Time: 21:34
 * Des: 更新指定权限组的权限详情
 */

//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$role_id = pathinfo(parse_url($_SERVER['REQUEST_URI'])['path'])['basename'];

//判断要查询的权限组是否存在
if (!count($GLOBALS['sql']->query("SELECT * FROM role WHERE id='$role_id'"))) error_handler(46008);

parse_str(file_get_contents('php://input'), $req_args);

//判断要更新的权限详情参数是否存在
if (!array_key_exists('new_permission', $req_args)) error_handler(44001);

$new_permission = $req_args['new_permission'];
$permission_len = $GLOBALS['sql']->query("SELECT count('id') FROM permission");
$permission_len = $permission_len[0]["count('id')"];

//如果权限详情参数长度不够自动补全
if (strlen($new_permission) < $permission_len) $new_permission = str_pad($new_permission, $permission_len, '0');

$GLOBALS['sql']->exec("UPDATE role SET permission='$new_permission' WHERE id='$role_id'");
$permission_json = array();
for ($i = 0; $i < strlen($new_permission); $i++) {
    $role_permission;
    $p = $GLOBALS['sql']->query("SELECT id, name, des FROM permission WHERE id=$i+1");
    $p_id = $p[0]['id'];
    $p_name = $p[0]['name'];
    $p_des = $p[0]['des'];
    $p_json = array(
        'id' => $p_id,
        'name' => $p_name,
        'des' => $p_des
    );
    if ($new_permission[$i] === '1') $p_json['checked'] = true;
    else $p_json['active'] = false;
    array_push($permission_json, $p_json);
}
print_r(json_encode(array(
    'permission' => $permission_json
)));
exit();