<?php
	//grades.php用于实现成绩有关的功能，学生可以查看个人成绩，教师可以查看所有学生的成绩
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
    
    if (!isset($_POST["id"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
    $qid = $_POST["id"];
    if (!check_user_type("Teacher")){
        $uid = $_COOKIE["User_ID"];
        $ret = $database->select("record", ["[>]quiz" => ["qid" => "id"]], ["record.uid", "quiz.name", "record.tot", "record.start"], ["AND" => ["record.uid" => $uid, "quiz.course" => $qid]]);
    }else{
        $ret = $database->select("record", ["[>]quiz" => ["qid" => "id"]], ["record.uid", "quiz.name", "record.tot", "record.start"], ["quiz.course" => $qid]);
    }

    return exit(json_encode(["status" => 0, "data" => $ret]));
?>