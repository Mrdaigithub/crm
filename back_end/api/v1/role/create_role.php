<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/11
 * Time: 22:29
 * Des: 新建一个权限组
 */


//检查当前用户是否有管理权限组的权限
if (!$GLOBALS['permission']->has_permission('system_role')) error_handler(48001);

$permission_len = $GLOBALS['sql']->query("SELECT count('id') FROM permission");
$permission_len = $permission_len[0]["count('id')"];
$new_role_permission = str_pad('', $permission_len, '0');

//检查参数是否缺失
if (!array_key_exists('new_role_name', $_POST)) error_handler(44001);

//检查权限组是否已存在
$role_list = $GLOBALS['sql']->query("SELECT role_name FROM role");
foreach ($role_list as $role_item) {
    if ($_POST['new_role_name'] === $role_item['role_name']) error_handler(46007);
}

$GLOBALS['sql']->exec("INSERT INTO role (role_name, permission) VALUES ('" . $_POST['new_role_name'] . "','$new_role_permission')");
print_r(json_encode(array(
    'new_role_info' => array(
        'name' => $_POST['new_role_name'],
        'permission' => $new_role_permission,
        'state' => false,
        'fixed' => false
    )
)));
exit();
