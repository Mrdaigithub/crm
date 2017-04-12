<?php

include '../../../core/core.php';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $count = $sql->query("SELECT count(*) FROM patient");
    $count = $count[0]['count(*)'];
    $page = $sql->query("SELECT count(*) FROM patient");
    print_r($count);
}

//new
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!array_key_exists('token', $_POST)) error_handler(41001);
    $post_data = $_POST;
    $username = $jwt->verifyToken($_POST['token']);
    $user_id = $sql->query("SELECT id FROM admin WHERE username='" . $username . "';");
    $user_id = $user_id[0]['id'];

    $patient_info = array(
        'name' => array_key_exists('name', $post_data) ? $post_data['name'] : null,
        'sex' => array_key_exists('sex', $post_data) ? $post_data['sex'] : 0,
        'age' => array_key_exists('age', $post_data) ? $post_data['age'] : null,
        'tel' => array_key_exists('tel', $post_data) ? $post_data['tel'] : null,
        'wechat' => array_key_exists('wechat', $post_data) ? $post_data['wechat'] : null,
        'qq' => array_key_exists('qq', $post_data) ? $post_data['qq'] : null,
        'add_time' => array_key_exists('addTime', $post_data) ? $post_data['addTime'] : null,
        'order_time' => array_key_exists('orderTime', $post_data) ? $post_data['orderTime'] : null,
        'reach_time' => array_key_exists('reachTime', $post_data) ? $post_data['reachTime'] : null,
        'disease_id' => array_key_exists('diseaseId', $post_data) ? $post_data['diseaseId'] : null,
        'author_id' => $user_id,
        'state' => array_key_exists('state', $post_data) ? $post_data['state'] : null,
        'media_from_id' => array_key_exists('mediaFromId', $post_data) ? $post_data['mediaFromId'] : null,
        'doctor_id' => array_key_exists('doctorId', $post_data) ? $post_data['doctorId'] : null,
        'advisory_way' => array_key_exists('advisoryWay', $post_data) ? $post_data['advisoryWay'] : null,
        'advisory_content' => array_key_exists('advisoryContent', $post_data) ? $post_data['advisoryContent'] : null,
        'area' => array_key_exists('area', $post_data) ? $post_data['area'] : null,
        'remarks' => array_key_exists('remarks', $post_data) ? $post_data['remarks'] : null
    );

    if ($patient_info['name'] === null
        || $patient_info['add_time'] === null
        || $patient_info['author_id'] === null
        || $patient_info['state'] === null
    ) error_handler(44001);

    $command = "INSERT INTO patient (";
    foreach ($patient_info as $key => $value) {
        if ($value !== null) $command .= $key . ',';
    }
    $command = substr($command, 0, strlen($command) - 1);
    $command .= ') VALUES (';
    foreach ($patient_info as $key => $value) {
        if ($value !== null) $command .= "'" . $value . "',";
    }
    $command = substr($command, 0, strlen($command) - 1);
    $command .= ');';
    if ($sql->exec($command)) {
        $res = $sql->query("SELECT * FROM patient WHERE name='" . $patient_info['name'] . "' AND add_time='" . $patient_info['add_time'] . "';");
        print_r(json_encode(array('new_patient'=>$res[0])));
        exit();
    }
}
