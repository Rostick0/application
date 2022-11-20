<?

class Project {
    public static function getMy($user_id, $limit = 20, $offset = 0) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `project` WHERE `project_id` IN (SELECT `project_id` FROM `project_access` WHERE `user_id` = '$user_id') ORDER BY `project_id` DESC LIMIT $limit OFFSET $offset");
    }

    public static function create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment = null, $complaint = null, $is_ready = 0, $status_payment_id = 1, $status_delivery_id = 1) {
        global $db_connect;

        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $count_defective = !empty($count_defective) ? "'$count_defective'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $price_commission = !empty($price_commission) ? "'$price_commission'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        $query = $db_connect->query("INSERT INTO
            `project` (`name`, `address`, `inn`, `start_date`, `end_date`, `count`, `count_defective`,`price`, `price_commission`, `comment`, `complaint`, `is_ready`, `status_payment_id`, `status_delivery_id`)
                VALUES
            ('$name','$address','$inn',$start_date,$end_date,$count,$count_defective,$price,$price_commission,$comment,$complaint,'$is_ready','$status_payment_id','$status_delivery_id')");
        
        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }

    public static function edit($project_id, $name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment = null, $complaint = null, $status_payment_id = 1, $status_delivery_id = 1) {
        global $db_connect;

        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $count_defective = !empty($count_defective) ? "'$count_defective'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $price_commission = !empty($price_commission) ? "'$price_commission'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        $db_connect->query("UPDATE `project`
        SET
        `name`='$name',`address`='$address',`inn`='$inn'`start_date`=$start_date,`end_date`=$end_date,`count`=$count,`count_defective`=$count_defective,`price`=$price,`price_commission`=$price_commission,`comment`=$comment,`complaint`=$complaint,`status_payment_id`='$status_payment_id',`status_delivery_id`='$status_delivery_id'
        WHERE `project_id` = '$project_id';");
    }
}

?>