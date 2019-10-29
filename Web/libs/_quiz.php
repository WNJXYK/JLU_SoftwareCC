<?php
    function get_quiz_state($qid, $uid){
        $database = get_database();
        $content = $database->get("quiz", "content", ["id" => $qid]);
        $content = json_decode($content, true);

        if ($database->count("record", ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $qid]]) == 0){
            $database->insert("record", ["uid" => $_COOKIE["User_ID"], "qid" => $qid, "start" => date('Y-m-d H:i:s'), "state" => 0, "score" => "{}", "answer" => "{}", "tot" => 0]);
            return ["msg" => "Task Started.", "answer" => "{}", "score" => "{}", "state" => 0];
        }else{
            $data = $database->get("record", ["start", "answer", "state", "score"], ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $qid]]);
            $state = $data["state"];
            if ($content["Time"] == 0 and $state == 0) return ["msg" => "No Time Limit.", "answer" => "{}", "score" => "{}", "state" => 0];
            
            $ddl = strtotime("+ {$content["Time"]} minutes", strtotime($data["start"]));
            $now = strtotime("now");
            
            if ($now <= $ddl and $state == 0) return ["msg" => "Remining ".date('i:s', $ddl - $now), "answer" => "{}", "score" => "{}", "state" => 0];
            
            if ($state == 0) {
                $database->update("record", ["state" => 4], ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $qid]]);
                $state = 4;
            }

            $msg = "";
            if ($state == 1) $msg = "Submitted.";
            if ($state == 2) $msg = "Waiting for teacher.";
            if ($state == 3) $msg = "Task is done.";
            if ($state == 4) $msg = "Over Due.";

            return ["msg" => $msg, "state" => $state, "answer" => $data["answer"], "score" => $data["score"]]; 
        }
        return [];
    }

    function get_quiz_answer($qid, $uid){
        $database = get_database();
        
        if ($database->count("record", ["AND" => ["uid" => $uid, "qid" => $qid]]) == 0){
            return ["msg" => "View Mode Stu #".$uid, "answer" => "{}", "score" => "{}", "state" => -1];
        }else{
            $data = $database->get("record", ["score", "answer", "state"], ["AND" => ["uid" => $uid, "qid" => $qid]]);
            if ($data["state"] == 0) return ["msg" => "Stu #".$uid." is solving.", "answer" => "{}", "score" => "{}", "state" => -1];
            $msg = ""; $state = $data["state"]; $ret = -2;
            if ($state == 1) $msg = "Submitted.";
            if ($state == 2) $msg = "Waiting for teacher.";
            if ($state == 3) { $msg = "Task is done."; $ret = -1; }
            if ($state == 4) { $msg = "Over Due."; $ret = -1; }
            return ["msg" => $msg, "state" => $ret, "answer" => $data["answer"], "score" => $data["score"]]; 
        }
    }

    function submit_quiz($qid, $uid, $answer){
        $database = get_database();
        $content = $database->get("quiz", "content", ["id" => $qid]);
        $content = json_decode($content, true);
        $score = [];
        $tot_score = 0;
        $flag = true;
        foreach($content["Problem"] as $pid){
            $problem = $database->get("problem", ["answer", "score", "type"], ["id" => $pid]);
            if ($problem["type"] == 0){
                if ($problem["answer"] == $answer["".$pid]) {
                    $score[$pid] = $problem["score"];
                    $tot_score += $problem["score"];
                }else $score[$pid] = 0;
            }else {
                $score[$pid] = "?";
                $flag = false;
            }
        }
        $state = 2;
        if ($flag) $state = 3;
        $database->update("record", ["answer"=> json_encode($answer), "score" => json_encode($score), "tot" => $tot_score, "state" => $state], ["AND" => ["uid" => $_COOKIE["User_ID"], "qid" => $qid]]);
    }

    function update_quiz($qid, $uid, $score){
        $database = get_database();
        $content = $database->get("quiz", "content", ["id" => $qid]);
        $content = json_decode($content, true);
        $tot_score = 0;
        $flag = true;
        foreach($content["Problem"] as $pid){
            $problem = $database->get("problem", ["score", "type"], ["id" => $pid]);
            $tot_score += max(min($problem["score"], $score[$pid]), 0);
        }
        $database->update("record", ["score" => json_encode($score), "tot" => $tot_score, "state" => 3], ["AND" => ["uid" => $uid, "qid" => $qid]]);
    }

?>