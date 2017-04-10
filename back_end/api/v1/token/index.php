<?php
include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') error_handler(43002);

//以帐号密码方式创建新token
if (array_key_exists('username',$_POST) && array_key_exists('password',$_POST)){
//    用戶名或密碼不合法
    if (preg_replace('/\s/','',$_POST['username'],-1) === ''
        || preg_replace('/\s/','',$_POST['password'],-1) === ''){
        error_handler(40035);
    }

    $username = trim($_POST['username']);
    $password = md5(addslashes(trim($_POST['password'])));

    $sqlAllUsername = $sql->query("SELECT username FROM admin");
    $realUsername = has_username($sqlAllUsername, $username);

//    用户名错误或无此用户
    if (!$realUsername) error_handler(46004);

    $sqlPassword = $sql->query("SELECT password FROM admin WHERE username='".$realUsername."';");
    //    密码错误
    if ($sqlPassword[0]['password'] !== $password) error_handler(46005);

//    为用户创建新token
    $token = $jwt->createToken($username);
    $command = "UPDATE admin SET token='".$token."', exp=".(time()+EXP)." WHERE username='".$username."';";
    $sql->exec($command);
    echo json_encode(array('token'=>$token));
    exit();
}

//以过期token换取新token
if (array_key_exists('token',$_POST)){
    $oldToken = $_POST['token'];
    $u = $sql->query("SELECT username FROM admin WHERE token='".$oldToken."';");
    $username = $u[0]['username'];

    //    为用户创建新token
    $token = $jwt->createToken($username);
    $command = "UPDATE admin SET token='".$token."', exp=".(time()+EXP)." WHERE username='".$username."';";
    $sql->exec($command);
    echo json_encode(array('token'=>$token));
    exit();
}
