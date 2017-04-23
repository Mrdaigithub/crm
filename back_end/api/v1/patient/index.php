<?php

include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $res = array();

    $count = $sql->query("SELECT count(*) FROM patient");
    $count = $count[0]['count(*)'];
<<<<<<< HEAD
    if (array_key_exists('count',$_GET)){
        print_r(json_encode(array(
            'count'=>$count
        )));
        exit();
    }
    if (array_key_exists('page',$_GET)) $page = $_GET['page'] ? $_GET['page'] : 1;
    if (array_key_exists('per_page',$_GET)) $per_page = $_GET['per_page'] ? $_GET['per_page'] : 20;
    if (array_key_exists('sort_by',$_GET)) $sort_by = $_GET['sort_by'] ? $_GET['sort_by'] : 'id';
    if (array_key_exists('order',$_GET)) $order = $_GET['order'] ? $_GET['order'] : 'asc';
    $command = "SELECT * FROM patient ORDER BY $sort_by $order LIMIT ".($page*$per_page-$per_page).",$per_page";
    $page_data = $sql->query($command);
    print_r(json_encode(array(
        'count'=>$count,
        'page_data'=>$page_data
    )));
=======
    $res['count'] = $count;

    if (!array_key_exists('page', $_GET) || !array_key_exists('per_page', $_GET)) error_handler(44001);

    $page = $_GET['page'] ? $_GET['page'] : 1;
    $per_page = $_GET['per_page'] ? $_GET['per_page'] : 30;
    $sort_by = $_GET['sort_by'] ? $_GET['sort_by'] : 'id';
    $order = $_GET['order'] ? $_GET['order'] : 'ASC';

    $admin_list = array();
    foreach ($sql->query("SELECT id,username FROM admin;") as $item){
        $admin_list = array_merge($admin_list,array($item['id']=>$item['username']));
    }

    $media_list = array();
    foreach ($sql->query("SELECT id,name FROM media;") as $item){
        $admin_list = array_merge($admin_list,array($item['id']=>$item['name']));
    }

    $command = "SELECT * FROM patient ORDER BY $sort_by $order LIMIT " . ($page * $per_page - $per_page) . ",$per_page;";
    $page_data = $sql->query($command);

    for ($i = 0; $i < count($page_data); $i++) {
        $page_data[$i]['add_time'] = $page_data[$i]['add_time'] === null ? $page_data[$i]['add_time'] : date('Y-m-d h:m:s', $page_data[$i]['add_time']);
        $page_data[$i]['order_time'] = $page_data[$i]['order_time'] === null ? $page_data[$i]['order_time'] : date('Y-m-d h:m:s', $page_data[$i]['order_time']);
        $page_data[$i]['reach_time'] = $page_data[$i]['reach_time'] === null ? $page_data[$i]['reach_time'] : date('Y-m-d h:m:s', $page_data[$i]['reach_time']);
        $page_data[$i]['state'] = $GLOBALS['PATIENT_STATE'][$page_data[$i]['state']];
        $page_data[$i]['author_id'] = $admin_list[$page_data[$i]['author_id']];
        $page_data[$i]['sex'] = $page_data[$i]['sex'] === 0 ? '男' : '女';
    }
    print_r(json_encode($page_data));
>>>>>>> e1fca208e33b9b9cf24deb9bacc137ae8cc24f94
    exit();
}

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
        'add_time' => array_key_exists('add_time', $post_data) ? $post_data['add_time'] : null,
        'order_time' => array_key_exists('order_time', $post_data) ? $post_data['order_time'] : null,
        'reach_time' => array_key_exists('reach_time', $post_data) ? $post_data['reach_time'] : null,
        'disease_id' => array_key_exists('disease_id', $post_data) ? $post_data['disease_id'] : null,
        'author_id' => $user_id,
        'state' => array_key_exists('state', $post_data) ? $post_data['state'] : null,
        'media_from_id' => array_key_exists('media_from_id', $post_data) ? $post_data['media_from_id'] : null,
        'doctor_id' => array_key_exists('doctor_id', $post_data) ? $post_data['doctor_id'] : null,
        'advisory_way' => array_key_exists('advisory_way', $post_data) ? $post_data['advisory_way'] : null,
        'advisory_content' => array_key_exists('advisory_content', $post_data) ? $post_data['advisory_content'] : null,
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
        print_r(json_encode(array('new_patient' => $res[0])));
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $req_args);
    $rm_patient_id = $req_args['id'];
    $sql->exec("DELETE FROM patient WHERE id=$rm_patient_id;");
    exit();
}

error_handler(43003);