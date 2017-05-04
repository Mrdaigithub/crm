<?php
/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/14
 * Time: 15:27
 */

include '../../../core/core.php';
if ($user_info->username !== 'root') error_handler(48001);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (array_key_exists('all', $_GET) && !!$_GET['all']) {
        print_r(1);
    } else {
        print_r(json_encode(array(
            'username' => $user_info->username,
            'role_name' => $user_info->role_name,
            'role_permission' => $user_info->role_permission
        )));
    }
    exit();
}

error_handler(43001);