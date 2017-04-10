<?php

/**
 * Created by PhpStorm.
 * User: mrdai
 * Date: 2017/4/9
 * Time: 19:21
 */
class class_mysql
{
    public $conn = null;

    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME, USERNAME, PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8"));
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function exec($sql)
    {
        $this->conn->exec($sql);
    }

    function query($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }
}
