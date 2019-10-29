<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
    if (!check_user_type("Teacher")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));
    if (!isset($_POST["qid"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameters."]));

    $qid = $_POST["qid"];
    $wait = $database->select("record", "uid", ["AND" => ["state"=> "2", "qid" => $qid]]);

    return exit(json_encode(["status" => 0, "data" => $wait]));
?>