<?php
    require_once("_user.php"); // User Auth Support
    if (!check_user_token()) exit(json_encode(["status" => -1, "msg" => "Not Login Yet."]));
    require_once("mysql.php"); // Mysql Support
    $database = get_database();

    $id = "2";
    $content = $database->get("quiz", ["name", "content"], ["id" => $id]);
    $json = json_decode($content["content"], true);
    print_r($json);

    if ($database->count("record", ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $id]]) == 0){
        $database->insert("record", ["uid" => $_COOKIE["User_ID"], "qid" => $id, "start" => date('Y-m-d H:i:s'), "state" => 0, "score" => "", "answer" => ""]);
        $content["msg"] = "Task Start.";
    }else{
        $data = $database->get("record", ["start", "answer", "state"], ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $id]]);
        $ddl = strtotime("+ {$json["Time"]} minutes", strtotime($data["start"]));
        $now = strtotime("now");

        // Judge Quiz End
        $is_end = false;
        if ($now <= $ddl or $json["Time"] == 0){
            $content["msg"] = "Remining ".date('H:i:s', $ddl - $now);
            if ($json["Time"] == 0) $content["msg"] = "No Time Limit.";
        }else $is_end = true;
        if ($data["state"] != 0) $is_end = true;

        // Update Contest State
        if ($is_end) $database->update("record", ["state" => 1])

        if ($is_end) $content["msg"] = "Task End.";
    }
    print_r($content);

    exit();

?>