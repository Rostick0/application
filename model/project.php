<?

class Project {
    public static function getMy($user_id, $limit = 20, $offset = 0) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `project` WHERE `project_id` IN (SELECT `project_id` FROM `project_access` WHERE `user_id` = '$user_id') ORDER BY `project_id` DESC LIMIT $limit OFFSET $offset");
    }

    public static function create($name, $contract, $address, $inn, $start_date, $end_date, $comment = null, $complaint = null, $zmo_id, $is_made_order = 0, $document_scan = 0, $documents = 0, $is_ready = 0) {
        global $db_connect;

        $address = !empty($address) ? "'$address'" : "NULL";
        $contract = !empty($contract) ? "'$contract'" : "NULL";
        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        $query = $db_connect->query("INSERT INTO
            `project` (`name`, `contract`, `address`, `inn`, `start_date`, `end_date`, `comment`, `complaint`, `zmo_id`, `is_made_order`, `document_scan`, `documents`, `is_ready`)
                VALUES
            ('$name',$contract,$address,'$inn',$start_date,$end_date,$comment,$complaint,'$zmo_id','$is_made_order', '$document_scan','$documents','$is_ready')");

        var_dump($db_connect->error);

        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }

    public static function edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $comment = null, $complaint = null, $zmo_id, $is_made_order = 0, $document_scan = 0, $documents = 0) {
        global $db_connect;

        $address = !empty($address) ? "'$address'" : "NULL";
        $contract = !empty($contract) ? "'$contract'" : "NULL";
        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        return $db_connect->query("UPDATE `project`
        SET
        `name`='$name',`contract`='$contract',`address`='$address',`inn`='$inn',`start_date`=$start_date,`end_date`=$end_date,`comment`=$comment,`complaint`=$complaint,`is_made_order`='$is_made_order',`zmo_id`='$zmo_id',`$document_scan`='document_scan',`documents`='$documents'
        WHERE `project_id` = '$project_id'");
    }

    public static function setReady($project_id, $is_ready) {
        global $db_connect;

        return $db_connect->query("UPDATE `project` SET `is_ready` = '$is_ready' WHERE `project_id` = '$project_id'");
    }
}

?>