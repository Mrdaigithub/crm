<?php
include '../../../core/core.php';

//以帐号密码方式新建token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 用戶名或密碼缺失
    if (!array_key_exists('username', $_POST) || !array_key_exists('password', $_POST))
        error_handler(40036);

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //用戶名或密碼不合法
    if (!preg_match('/^[0-9a-zA-Z]{4,15}$/', $username) || !preg_match('/^[0-9a-zA-Z]{4,15}$/', $password))
        error_handler(40035);

    $has_username = $sql->query("SELECT username FROM admin WHERE username='" . $username . "';");

//    用户名错误或无此用户
    if (!$has_username) error_handler(46004);

    $password = md5(addslashes(trim($_POST['password'])));
    $sql_password = $sql->query("SELECT password FROM admin WHERE username='" . $username . "';");

    //    密码错误
    if ($sql_password[0]['password'] !== $password) error_handler(46005);

    //    为用户创建新token
    $token = $jwt->create_token($username);
    $sql->exec("UPDATE admin SET token='" . $token . "', exp=" . (time() + EXP) . " WHERE username='" . $username . "';");
    echo json_encode(array('token' => $token));

    exit();
}


//过期token更新
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents('php://input'), $req_args);

//    缺少token参数
    if (!array_key_exists('token', $req_args)) error_handler(41001);

    $old_token = $req_args['token'];
    $username = $sql->query("SELECT username FROM admin WHERE token='" . $old_token . "';");

//    无效的token
    if (!$username) error_handler(40014);
    $username = $username[0]['username'];

    //    为用户创建新token
    $token = $jwt->create_token($username);
    $sql->exec("UPDATE admin SET token='" . $token . "', exp=" . (time() + EXP) . " WHERE username='" . $username . "';");
    echo json_encode(array('token' => $token, 'username' => $username));
    exit();
}
