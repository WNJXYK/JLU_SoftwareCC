<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("mysql.php"); // Mysql Support
    require_once("_user.php"); // User Auth Support

    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])){
            $list = $database->select("course", ["id", "name", "info"], ["id[>]" => 0]);
            exit(json_encode(["status" => 0, "data" => $list]));
        }else{
            $id = $_GET["id"];
            $content = $database->get("course", ["home", "syllabus", "module", "info"], ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => $content]));
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!check_user_type("Teacher")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
        if (!isset($_POST["id"])) exit(json_encode(["status" => -1, "msg" => "Need Course ID"]));
        $id = $_POST["id"];
        $arr = [];
        if (isset($_POST["module"])) $arr["module"] = $_POST["module"];
        if (isset($_POST["home"])) $arr["home"] = $_POST["home"];
        if (isset($_POST["syllabus"])) $arr["syllabus"] = $_POST["syllabus"];
        if (isset($_POST["info"])) $arr["info"] = $_POST["info"];
        $database->update("course", $arr, ["id" => $id]);
        exit(json_encode(["status" => 0, "data" => ""]));
    }



?>