<?php

include '../../../core/core.php';

//获取权限树
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!$permission->has_permission('system_permission')) error_handler(48001);
    $permission_json = array();
    $root_permission_node = $sql->query("SELECT id, title, level FROM permission WHERE level=1");
    foreach ($root_permission_node as $r_item) {
        $r_item = array_merge($r_item, array('expand' => true));
        $parent_permission_node = $sql->query("select id,title,level from permission where level=2 AND parent_id='" . $r_item['id'] . "';");
        foreach ($parent_permission_node as $p_item) {
            $p_item = array_merge($p_item, array('children' => array(), 'expand' => true));
            $permission_node = $sql->query("select id,title,level from permission where level=3 AND parent_id='" . $p_item['id'] . "';");
            if (count($permission_node)) {
                foreach ($permission_node as $item) {
                    array_push($p_item['children'], $item);
                }
            }
            array_push($r_item['children'], $p_item);
        }
        array_push($permission_json, $r_item);
    }
    print_r($permission_json);
    exit();
}

error_handler(43003);
