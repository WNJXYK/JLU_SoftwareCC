<?php
    include_once("config.php");
    require_once("medoo.php");

    function get_database(){
        $database = new medoo([
            'database_type' => 'mysql',
            'database_name' => MYSQL_DATABASE,
            'server' => MYSQL_HOST,
            'username' => MYSQL_USERNAME,
            'password' => MYSQL_PASSWORD,
            'charset' => 'utf8',
            "prefix" => MYSQL_PREFIX,
            'port' => 3306
        ]);
        return $database;
    }
?>