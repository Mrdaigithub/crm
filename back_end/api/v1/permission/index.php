<?php

include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    if (!$permission->has_permission('system_permission')) error_handler(48001);
    $permission_data = $sql->query("SELECT id,des,level FROM permission;");
    foreach ($permission_data as $item){
        if (strlen($item['level']) === 1)
            print_r($item);
    }
    exit();
}

error_handler(43003);
