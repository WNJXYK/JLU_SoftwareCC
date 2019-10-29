<?php
	ini_set("display_errors", 0);
	error_reporting(E_ALL ^ E_NOTICE);
	error_reporting(E_ALL ^ E_WARNING);
	
	header('Content-Type:application/json; charset=utf-8'); // Return in json
	require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");
	require_once("mysql.php"); // Mysql Support
	require_once("_user.php"); // User Auth Support

	if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));

	$database = get_database();
	$uid = $_COOKIE["User_ID"];

	if ($_SERVER['REQUEST_METHOD'] == 'GET'){
		$ret = $database->select("file", ["id", "name", "size", "path"], ["user" => $uid]);
		exit(json_encode(["status"=>0, "data"=> $ret ]));
	}


	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		if (isset($_POST["id"])){
			$path = $database->get("file", "path", ["id" => $_POST["id"]]);
			$path = str_replace(URL_PATH, $_SERVER['DOCUMENT_ROOT'], $path);
			if (unlink($path)){
				$database->delete("file", ["id" => $_POST["id"]]);
				exit(json_encode(["status"=>0, "data"=> "" ]));
			}else exit(json_encode(["status"=>-1, "msg"=> "System Error" ]));
		}else{
			$siz = $_FILES["file"]["size"];
			$name = $_FILES["file"]["name"];
			
			$path = "../uploads/". $uid . date(). time() . '-' . $name;
			$uni = strtoupper ( md5 ( uniqid ( rand (), true ) ) );
			$rest_siz = (50 * 1024  - $database->sum("file", "size", ["user" => $uid]) ) * 1024;

			if ($_FILES["file"]["error"] > 0) exit(json_encode(["status"=>-1, "msg"=> $_FILES["file"]["error"]]));
			if ($siz > $rest_siz) exit(json_encode(["status"=>-1, "msg"=> "You do not have enough space for new file({$siz} KB). [{$rest_siz} KB of 50MB]"]));
			$siz = $siz / 1024; $rest_siz = $rest_siz / 1024;
			if (file_exists($path)) exit(json_encode(["status"=>-1, "msg"=> "Wait and Try Again."]));
			if (move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].$path)){
				$database->insert("file", ["name" => $name, "path" => URL_PATH. $path, "size" => $siz, "user" => $uid]);
				exit(json_encode(["status"=>0, "data"=> ""]));
			}else exit(json_encode(["status"=>-1, "msg"=> "System Error"]));
		}
	}
?>