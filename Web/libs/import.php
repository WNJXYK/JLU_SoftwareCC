<?php

	header('Content-Type:application/json; charset=utf-8'); // Return in json
	require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	require_once("mysql.php"); // Mysql Support
	require_once("_user.php"); // User Auth Support

	if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));
    if (!check_user_type("Admin")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));

	$database = get_database();

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (!isset($_POST["id"]) or !isset($_POST["type"]) or !isset($_POST["nickname"]) or !isset($_POST["password"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameter"]));
            $id = $_POST["id"];
            $type = $_POST["type"];
            $nickname = $_POST["nickname"];
            $password = md5($_POST["password"]);
            
            $last = $database->insert("user", ["id" => $id, "type"=>$type, "nickname"=>$nickname, "password"=>$password]);

            exit(json_encode(["status" => 0, "data" =>$last]));
	}
?>