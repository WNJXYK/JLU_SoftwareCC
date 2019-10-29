<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
    require_once(LIB_PATH . "medoo.php");

    function get_database(){
        $database = new medoo([
            'database_type' => 'mysql',
            'database_name' => MYSQL_DATABASE,
            'server' => 'localhost',
            'username' => MYSQL_USERNAME,
            'password' => MYSQL_PASSWORD,
            'charset' => 'utf8',
            'port' => 3306
        ]);
        return $database;
    }
?>