<?php
    header('Content-Type:application/json; charset=utf-8'); // Return in json
    
    require_once("mysql.php"); // Mysql Support
    $database = get_database();
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST["id"]) and isset($_POST["pwd"])){
        // Login
        $count = $database->count("user", [ "AND" => [ "id" => $_POST["id"], "password" => $_POST["pwd"] ] ]);
        if ($count > 0){ // Login Success
            // Allocate Token
            $token = md5(uniqid(microtime(true), true));
            $database->update("user", ["token" => $token ], ["id" => $_POST["id"]]);
            
            // Get Information
            $info = $database->get("user", ["nickname", "type"], ["id" => $_POST["id"]]);

            // Set Cookie
            setcookie("User_Nick", $info["nickname"], time() + 3600 * 24, "/");
            setcookie("User_Type", $info["type"], time() + 3600 * 24, "/");
            setcookie("User_ID", $_POST["id"], time() + 3600 * 24, "/");
            setcookie("User_Token", $token, time() + 3600 * 24, "/");

            $arr = array('status' => 0, 'msg' => $info);
        }else{ // Login Failed
            $arr = array('status' => -1, 'msg' => "Incorrect User ID or Password.");
        }
 
    }else{ // Wrong Method for Login
        $arr = array('status' => -1, 'msg' => "Wrong Request Method.");
    }

    // return Json
    exit(json_encode($arr));
?>