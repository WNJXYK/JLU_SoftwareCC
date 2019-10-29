<?php
	//mail.php文件主要用于实现发送和获取邮件
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("mysql.php"); // Mysql Support
    require_once("_user.php"); // User Auth Support

    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])){
            $list = $database->select("mails", ["id", "from_user", "to_user", "title", "time"], ["OR" => ["to_user" => $_COOKIE["User_ID"], "from_user" => $_COOKIE["User_ID"]], "ORDER" => ["time" => "DESC"],]);
            exit(json_encode(["status" => 0, "data" => $list]));
        }else{
            $id = $_GET["id"];
            $content = $database->get("mails", ["from_user", "to_user", "title", "content", "time"], ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => $content]));
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $from = $_COOKIE["User_ID"];
        $to = $_POST["to"];
        $title = $_POST["title"];
        $content = $_POST["content"];

        $last =$database->insert("mails", ["from_user" => $from, "to_user" => $to, "title" => $title, "content" => $content]);
        // $last = $database->insert("problem", ["statement" =>"12", "quiz" =>"!@3", "content" => "123", "score" => 5, "type" => 0, "answer" => 0]);
        exit(json_encode(["status" => 0, "data" => $last]));
    }
  


?>