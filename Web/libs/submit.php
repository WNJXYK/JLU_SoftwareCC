<?php
	//submit.php文件主要用于实现学生提交答案的功能
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    require("_quiz.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (check_user_type("Student")){
            if (!isset($_POST["answer"]) or !isset($_POST["qid"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            submit_quiz($_POST["qid"], $_COOKIE["User_ID"], json_decode($_POST["answer"], true));
        }else{
            if (!isset($_POST["uid"]) or !isset($_POST["score"]) or !isset($_POST["qid"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            update_quiz($_POST["qid"], $_POST["uid"], json_decode($_POST["score"], true));
        }
    }

    exit(json_encode(["status" => 0, "data" => ""]));
?>