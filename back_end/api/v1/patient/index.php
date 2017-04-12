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
    $postData = $_POST;
    $username = $jwt->verifyToken($_POST['token']);
    $userId = $sql->query("SELECT id FROM admin WHERE username='" . $username . "';");
    $userId = $userId[0]['id'];

    $patientInfo = array(
        'name' => array_key_exists('name', $postData) ? $postData['name'] : null,
        'sex' => array_key_exists('sex', $postData) ? $postData['sex'] : 0,
        'age' => array_key_exists('age', $postData) ? $postData['age'] : null,
        'tel' => array_key_exists('tel', $postData) ? $postData['tel'] : null,
        'wechat' => array_key_exists('wechat', $postData) ? $postData['wechat'] : null,
        'qq' => array_key_exists('qq', $postData) ? $postData['qq'] : null,
        'addTime' => array_key_exists('addTime', $postData) ? $postData['addTime'] : null,
        'orderTime' => array_key_exists('orderTime', $postData) ? $postData['orderTime'] : null,
        'reachTime' => array_key_exists('reachTime', $postData) ? $postData['reachTime'] : null,
        'diseaseId' => array_key_exists('diseaseId', $postData) ? $postData['diseaseId'] : null,
        'authorId' => $userId,
        'state' => array_key_exists('state', $postData) ? $postData['state'] : null,
        'mediaFromId' => array_key_exists('mediaFromId', $postData) ? $postData['mediaFromId'] : null,
        'doctorId' => array_key_exists('doctorId', $postData) ? $postData['doctorId'] : null,
        'advisoryWay' => array_key_exists('advisoryWay', $postData) ? $postData['advisoryWay'] : null,
        'advisoryContent' => array_key_exists('advisoryContent', $postData) ? $postData['advisoryContent'] : null,
        'area' => array_key_exists('area', $postData) ? $postData['area'] : null,
        'remarks' => array_key_exists('remarks', $postData) ? $postData['remarks'] : null
    );

    if ($patientInfo['name'] === null
        || $patientInfo['addTime'] === null
        || $patientInfo['authorId'] === null
        || $patientInfo['state'] === null
    ) error_handler(44001);

    $command = "INSERT INTO patient (";
    foreach ($patientInfo as $key => $value) {
        if ($value !== null) $command .= $key . ',';
    }
    $command = substr($command, 0, strlen($command) - 1);
    $command .= ') VALUES (';
    foreach ($patientInfo as $key => $value) {
        if ($value !== null) $command .= "'" . $value . "',";
    }
    $command = substr($command, 0, strlen($command) - 1);
    $command .= ');';
    if ($sql->exec($command)) {
        $res = $sql->query("SELECT * FROM patient WHERE name='" . $patientInfo['name'] . "' AND addTime='" . $patientInfo['addTime'] . "';");
        print_r(json_encode(array('newPatient'=>$res[0])));
        exit();
    }
}
