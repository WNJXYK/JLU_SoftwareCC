<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
    require_once(LIB_PATH . "mysql.php"); // Mysql Support
    
    // Check Whether User Token is Valided.
    function check_user_token(){
        if (!isset($_COOKIE["User_ID"]) or !isset($_COOKIE["User_Token"])) return false;
        
        $database = get_database();
        $id = $_COOKIE["User_ID"];
        $token = $_COOKIE["User_Token"];
        $count = $database->count("user", ["AND" => [ "id" => $id, "token" => $token ] ]);

        return $count > 0;
    }

    // Check Whether User Token is Valided.
    function check_user_type($type){
        if (!isset($_COOKIE["User_ID"]) or !isset($_COOKIE["User_Token"])) return false;
        
        $database = get_database();
        $id = $_COOKIE["User_ID"];
        $token = $_COOKIE["User_Token"];
        $count = $database->count("user", ["AND" => [ "id" => $id, "token" => $token, "type" => $type] ]);

        return $count > 0;
    }
?>