<?php

	header('Content-Type:application/json; charset=utf-8'); // Return in json
	require_once("config.php");
	require_once("mysql.php"); // Mysql Support
	require_once("_user.php"); // User Auth Support

	if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));
    if (!check_user_type("Admin")) exit(json_encode(["status" => -1, "msg" => "Access Denied."]));

	$database = get_database();

	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_POST["id"])){
            $id = $_POST["id"];

            $list = $database->select("quiz", "id", ["course" => $id]);
            foreach($list as $qid){
                $database->delete("record", ["qid" => $qid]);
                $database->delete("problem", ["quiz" => $qid]);
            }

            $list = $database->select("markdown", "id", ["course" => $id]);
            foreach($list as $pid){
                $database->delete("comment", ["post" => $pid]);
            }

            $database->delete("markdown", ["course" => $id]);
            $database->delete("quiz", ["course" => $id]);
            $database->delete("course", ["id" => $id]);
            exit(json_encode(["status" => 0, "data" => ""]));
		}else{
            if (!isset($_POST["name"]) or !isset($_POST["info"])) exit(json_encode(["status" => -1, "msg" => "Wrong Parameter"]));
            $name = $_POST["name"];
            $info = $_POST["info"];
            $module = '{"Modules": []}';

            $last = $database->insert("course", ["name" => $name, "info"=>$info, "home"=>0, "syllabus"=>0, "module"=>$module]);

            $home = $database->insert("markdown", [ "course" => $last, "content" => "# Home"]);
            $syllabus = $database->insert("markdown", [ "course" => $last, "content" => "# Syllabus"]);
            $database->update("course", ["home"=>$home, "syllabus"=>$syllabus], ["id" => $last]);
            
            exit(json_encode(["status" => 0, "data" => $last]));
		}
	}
?>