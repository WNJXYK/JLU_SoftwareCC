<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
        $id = $_GET["id"];
        $comment = $database->get("user", "*", ["id" => $id]);
        exit(json_encode(["status" => 0, "data" => $comment]));
    }
?>