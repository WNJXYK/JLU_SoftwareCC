<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    require("_quiz.php");

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
        $id = $_GET["id"];
        $content = $database->get("quiz", ["name", "content"], ["id" => $id]);
        $json = json_decode($content, true);
        if (check_user_type("Student")) {
            $content["extra"] = get_quiz_state($id, $_COOKIE["User_ID"]);
        }else{
            if (isset($_GET["uid"])){
                $uid = $_GET["uid"];
                $content["extra"] = get_quiz_answer($id, $uid);
            }else{
                $content["extra"] = ["msg" => "View Mode", "state" => -1];
            }
            
        }
        exit(json_encode(["status" => 0, "data" => $content]));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!check_user_type("Teacher")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
        if (!isset($_POST["id"])){
            if (!isset($_POST["course"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $course = $_POST["course"];
            $content = '{"Problem": [], "Score": 0, "Time": 20}';
            $last = $database->insert("quiz", ["name" => "Task", "course" => $course, "content" => $content]);
            exit(json_encode(["status" => 0, "data" => $last]));
        }else{
            if (!isset($_POST["name"]) or !isset($_POST["content"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $id = $_POST["id"];
            $name = $_POST["name"];
            $content = $_POST["content"];
            $cnt = $database->update("quiz", ["content" => $content, "name" => $name], ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => $cnt]));
        }
    }
?>