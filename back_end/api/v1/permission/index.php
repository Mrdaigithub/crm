<?php

include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$permission->has_permission('system_permission')) error_handler(48001);
    $permission_data = $sql->query("SELECT id,des,level FROM permission;");
    $permission_json = array();
    foreach ($permission_data as $item) {
        if (strlen($item['level']) === 1)
            array_push($permission_json, array(
                'title' => $item['des'],
                'level' => $item['level'],
                'expand' => true,
                'children' => array()
            ));
    }
    foreach ($permission_data as $item) {
        if (preg_match('/^\d-\d+$/', $item['level'])) {
            $root_level = $item['level'][0];
            for ($i = 0; $i < count($permission_json); $i++) {
                if ($permission_json[$i]['level'] === $root_level) {
                    array_push($permission_json[$i]['children'], array(
                        'title' => $item['des'],
                        'level' => $item['level'],
                        'expand' => true,
                        'children' => array()
                    ));
                }
            }
        }
    }
    foreach ($permission_data as $item) {
        if (preg_match('/^\d-\d+-\d+$/', $item['level'])) {
            $level = explode('-', $item['level']);
            $root_level = $level[0];
            $parent_level = $level[1];
            for ($i = 0; $i < count($permission_json); $i++) {
                if ($permission_json[$i]['level'][0] === $root_level){
//                    for ($j = 0; $j < count($permission_json[$i]['children']); $j++)
//                    array_push($permission_json[$i]['children'],array(
//                        'title' => $item['des'],
//                        'level' => $item['level'],
//                        'expand' => true,
//                        'children' => array()
//                    ));
                }
            }
        }
    }
//    print_r(json_encode($permission_json));
    exit();
}

error_handler(43003);
