<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        if (!isset($_GET["id"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
        $id = $_GET["id"];
        $arr = ["id", "statement", "content", "score", "type"];
        $content = $database->get("problem", $arr, ["id" => $id]);
        exit(json_encode(["status" => 0, "data" => $content]));
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if (!check_user_type("Teacher")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
        if (!isset($_POST["id"])){
            if (!isset($_POST["quiz"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $quiz = $_POST["quiz"];
            $statement = "Please Choose From A, B, C, D. (Answer is A)";
            $content = '"{\n    \"Problem\": [\n        \"A\",\n        \"B\",\n        \"C\",\n        \"D\"\n    ]\n}"';
            $last = $database->insert("problem", ["statement" => $statement, "quiz" => $quiz, "content" => $content, "score" => 5, "type" => 0, "answer" => 0]);
            exit(json_encode(["status" => 0, "data" => $last]));
        }else{
            if (!isset($_POST["content"]) or !isset($_POST["statement"]) or !isset($_POST["score"]) or !isset($_POST["type"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));
            $id = $_POST["id"];
            $statement = $_POST["statement"];
            $score = $_POST["score"];
            $content = $_POST["content"];
            $type = $_POST["type"];
            $answer = $_POST["answer"];
            $database->update("problem", ["statement" => $statement, "content" => $content, "score" => $score, "type" => $type, "answer"=>$answer], ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => ""]));
        }
    }
?>