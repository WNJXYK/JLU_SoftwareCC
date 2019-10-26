<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["post"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
        $post = $_GET["post"];
        $comment = $database->select("comment", "*", ["post" => $post]);
        exit(json_encode(["status" => 0, "data" => $comment]));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!isset($_POST["id"])){
            if (!isset($_POST["content"]) or !isset($_POST["post"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $arr = ["content" => $_POST["content"], "post" => $_POST["post"], "author" => $_COOKIE["User_ID"]];
            if (isset($_POST["reply"])) $arr["reply"] = $_POST["reply"];
            $last = $database->insert("comment", $arr);
            exit(json_encode(["status" => 0, "data" => $last]));
        }else{
            $id = $_POST["id"];
            $author = $database->get("comment", "author", ["id" => $id]);
            if (!check_user_type("Teacher") and $author != $_COOKIE["User_ID"]) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
            $database->update("comment", ["reply" => 0], ["reply" => $id]);
            $database->delete("comment", ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => ""]));
        }
    }
?>