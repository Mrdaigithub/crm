<?php

include '../../../core/core.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET'){
    $doctors = $sql->query("SELECT * FROM doctors;");
    print_r($doctors);
}