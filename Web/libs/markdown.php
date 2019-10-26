<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
        $id = $_GET["id"];
        $content = $database->get("markdown", "content", ["id" => $id]);
        exit(json_encode(["status" => 0, "data" => $content]));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!check_user_type("Teacher")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
        if (!isset($_POST["id"])){
            $last = $database->insert("markdown", [ "content" => ""]);
            exit(json_encode(["status" => 0, "data" => $last]));
        }else{
            if (!isset($_POST["content"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $id = $_POST["id"];
            $content = $_POST["content"];
            $database->update("markdown", ["content" => $content], ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => ""]));
        }
    }
?>