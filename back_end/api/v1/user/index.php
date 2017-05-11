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
    print_r(json_encode($sql->query("SELECT u.id, u.username, u.state, u.tel, r.role_name FROM users u, role r WHERE u.role_id=r.id;")));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('username', $req_args) ||
        !array_key_exists('password', $req_args) ||
        !array_key_exists('tel', $req_args) ||
        !array_key_exists('role_name', $req_args)
    ) error_handler(44001);
    $username_list = $sql->query("SELECT username FROM users");

    $username = $_POST['username'];
//    用户名已存在
    foreach ($username_list as $username_item){
        if ($username === $username_item['username']){
            error_handler(46006);
            exit();
        }
    }
    $password = md5($_POST['password']);
    $tel = $_POST['tel'];
    $role_name = $_POST['role_name'];
    $role_id = $sql->query("SELECT id FROM role WHERE role_name='$role_name'");
    $role_id = $role_id[0]['id'];

    $sql->exec("INSERT INTO users (username, password, role_id, state, tel) VALUES ('$username','$password', $role_id, false,'$tel')");
    $new_user = $sql->query("SELECT id, username, state, tel FROM users WHERE username='$username'");
    $new_user = $new_user[0];
    $new_user['role_name'] = $role_name;
    print_r(json_encode($new_user));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('username', $req_args) ||
        !array_key_exists('tel', $req_args) ||
        !array_key_exists('id', $req_args) ||
        !array_key_exists('role_name', $req_args)
    ) error_handler(44001);
    $username_list = $sql->query("SELECT username FROM users");

    $username = $_POST['username'];
//    用户名已存在
    foreach ($username_list as $username_item){
        if ($username === $username_item['username']){
            error_handler(46006);
            exit();
        }
    }

    if (array_key_exists('password', $req_args)){
        $password = md5($_POST['password']);
    }
    $tel = $req_args['tel'];
    $tel = $req_args['tel'];
    $role_name = $req_args['role_name'];
    $role_id = $sql->query("SELECT id FROM role WHERE role_name='$role_name'");
    $role_id = $role_id[0]['id'];

    $sql->exec("INSERT INTO users (username, password, role_id, state, tel) VALUES ('$username','$password', $role_id, false,'$tel')");
    $new_user = $sql->query("UPDATE users SET username='$username',state=1 WHERE id='kefu3'");
    $new_user = $new_user[0];
    $new_user['role_name'] = $role_name;
    print_r(json_encode($new_user));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $req_args);
    if (!array_key_exists('username', $req_args)) error_handler(44001);
    $sql->exec("DELETE FROM users WHERE username='" . $req_args['username'] . "'");
    exit();
}

error_handler(43003);
