<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/5/3
 * Time: 21:03
 */

include '../../../core/core.php';
if ($user_info->username !== 'root') error_handler(48001);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $role_name_list = $sql->query("SELECT name, state, fixed FROM role");
    print_r(json_encode($role_name_list));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!array_key_exists('new_role_name', $_POST)) error_handler(44001);
    $permission_len = $sql->query("SELECT count('id') FROM permission");
    $permission_len = $permission_len[0]["count('id')"];
    $new_role_permission = str_pad('', $permission_len, '0');
    $sql->exec("INSERT INTO role (name, permission) VALUES ('" . $_POST['new_role_name'] . "','$new_role_permission')");
}

if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('role_name',$req_args) || !array_key_exists('state',$req_args)) error_handler(44001);
    $sql->exec("UPDATE role SET state=".$req_args['state']." WHERE name='".$req_args['role_name']."'");
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('role_name', $req_args)) error_handler(44001);
    $sql->exec("DELETE FROM role WHERE name='" . $req_args['role_name'] . "'");
}