<?

class Project
{
    public static function get($status_date, $is_ready, $limit, $offset)
    {
        global $db_connect;

        $sql_add = "";

        if ($status_date) {
            $sql_add = "WHERE `status_date` IN ($status_date)";
        }

        if ($sql_add) {
            if ($is_ready) {
                $sql_add = " AND `is_ready` = '$is_ready'";
            }
        } else {
            $sql_add = "WHERE `is_ready` = '$is_ready'";
        }

        return $db_connect->query("SELECT * FROM `project` $sql_add ORDER BY `project_id` DESC LIMIT $limit OFFSET $offset");
    }

    public static function getCount($status_date, $is_ready)
    {
        global $db_connect;

        $sql_add = "";

        if ($status_date) {
            $sql_add = "WHERE `status_date` IN ($status_date)";
        }

        if ($sql_add) {
            if ($is_ready) {
                $sql_add = " AND `is_ready` = '$is_ready'";
            }
        } else {
            $sql_add = "WHERE `is_ready` = '$is_ready'";
        }

        return $db_connect->query("SELECT COUNT(*) FROM `project` $sql_add")->fetch_assoc()['COUNT(*)'];
    }

    public static function search($name, $project_id, $status_date, $is_ready, $limit, $offset)
    {
        global $db_connect;

        $sql_add = "";

        if ($status_date) {
            $sql_add = "AND `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date))";
        }

        if ($is_ready) {
            $sql_add .= " AND `is_ready` = '$is_ready'";
        }

        $name = !empty($name) ? "'%$name%'" : "NULL";
        $project_id = !empty($project_id) ? "'%$project_id%'" : "NULL";

        $query = $db_connect->query("SELECT * FROM `project`
        WHERE `name` LIKE $name $sql_add
        UNION SELECT * FROM `project`
        WHERE `project_id` LIKE $project_id $sql_add ORDER BY `project_id` DESC LIMIT $limit OFFSET $offset");

        return $query;
    }

    public static function searchCount($name, $project_id, $is_ready, $status_date)
    {
        global $db_connect;

        var_dump($is_ready);

        $sql_add = "";

        if ($status_date) {
            $sql_add = "AND `project_id` IN (SELECT `project_id` FROM `project` WHERE `status_date` in ($status_date))";
        }

        if ($is_ready) {
            $sql_add .= " AND `is_ready` = '$is_ready'";
        }

        $name = !empty($name) ? "'%$name%'" : "NULL";
        $project_id = !empty($project_id) ? "'%$project_id%'" : "NULL";

        $query = $db_connect->query("SELECT COUNT(*) FROM
        (
            SELECT * FROM `project`
            WHERE `name` LIKE $name $sql_add
            UNION
            SELECT * FROM `project`
            WHERE `project_id` LIKE $project_id $sql_add
        )
        
        `counter`");

        return $query->fetch_assoc()["COUNT(*)"];
    }

    public static function getMy($user_id, $limit = 20, $offset = 0)
    {
        global $db_connect;

        $query = $db_connect->query("SELECT * FROM `project` WHERE `project_id` IN (SELECT `project_id` FROM `project_access` WHERE `user_id` = '$user_id') ORDER BY `project_id` DESC LIMIT $limit OFFSET $offset");

        return $query;
    }

    public static function create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment = null, $complaint = null, $zmo_id, $is_made_order = 0, $document_scan = 0, $documents = 0, $is_ready = 0)
    {
        global $db_connect;

        $name = !empty($name) ? "'$name'" : "NULL";
        $address = !empty($address) ? "'$address'" : "NULL";
        $contract = !empty($contract) ? "'$contract'" : "NULL";
        $inn = !empty($inn) ? "'$inn'" : "NULL";
        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $delivery_date = !empty($delivery_date) ? "'$delivery_date'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        $query = $db_connect->query("INSERT INTO
            `project` (`name`, `contract`, `address`, `inn`, `start_date`, `end_date`, `delivery_date`, `comment`, `complaint`, `zmo_id`, `is_made_order`, `document_scan`, `documents`, `is_ready`)
                VALUES
            ($name,$contract,$address,$inn,$start_date,$end_date,$delivery_date,$comment,$complaint,'$zmo_id','$is_made_order', '$document_scan','$documents','$is_ready')");

        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }

    public static function edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment = null, $complaint = null, $zmo_id, $is_made_order = 0, $document_scan = 0, $documents = 0)
    {
        global $db_connect;

        $name = !empty($name) ? "'$name'" : "NULL";
        $address = !empty($address) ? "'$address'" : "NULL";
        $contract = !empty($contract) ? "'$contract'" : "NULL";
        $inn = !empty($inn) ? "'$inn'" : "NULL";
        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $delivery_date = !empty($delivery_date) ? "'$delivery_date'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        $query = $db_connect->query("UPDATE `project`
        SET
        `name`=$name,`contract`=$contract,`address`=$address,`inn`=$inn,`start_date`=$start_date,`end_date`=$end_date,`delivery_date`=$delivery_date,`comment`=$comment,`complaint`=$complaint,`is_made_order`='$is_made_order',`zmo_id`='$zmo_id',`document_scan`='$document_scan',`documents`='$documents'
        WHERE `project_id` = '$project_id'");

        return $query;
    }

    public static function setReady($project_id, $is_ready)
    {
        global $db_connect;

        $query = $db_connect->query("UPDATE `project` SET `is_ready` = '$is_ready' WHERE `project_id` = '$project_id'");

        return $query;
    }

    public static function setStatusDate($project_id, $status_date)
    {
        global $db_connect;

        $status_date = !empty($status_date) ? "'$status_date'" : "NULL";

        return $db_connect->query("UPDATE `project` SET `status_date` = $status_date WHERE `project_id` = '$project_id'");
    }

    public static function delete($project_id)
    {
        global $db_connect;

        $db_connect->query("DELETE FROM `product` WHERE `project_id` = '$project_id'");
        $db_connect->query("DELETE FROM `project_access` WHERE `project_id` = '$project_id'");
        return $db_connect->query("DELETE FROM `project` WHERE `project_id` = '$project_id'");
    }
}

?>