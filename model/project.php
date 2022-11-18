<?

class Project {
    public static function create($name, $address, $inn, $start_date, $end_date, $count, $count_defective, $price, $price_commission, $comment = null, $complaint = null, $is_ready = 0, $status_payment_id = 1, $status_delivery_id = 1) {
        global $db_connect;

        $start_date = !empty($start_date) ? "'$start_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $end_date = !empty($end_date) ? "'$end_date'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $count_defective = !empty($count_defective) ? "'$count_defective'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $price_commission = !empty($price_commission) ? "'$price_commission'" : "NULL";
        $comment = !empty($comment) ? "'$comment'" : "NULL";
        $complaint = !empty($complaint) ? "'$complaint'" : "NULL";

        return $db_connect->query("INSERT INTO
            `project` (`name`, `address`, `inn`, `start_date`, `end_date`, `count`, `count_defective`,`price`, `price_commission`, `comment`, `complaint`, `is_ready`, `status_payment_id`, `status_delivery_id`)
                VALUES
            ('$name','$address','$inn',$start_date,$end_date,$count,$count_defective,'$price','$price_commission',$comment,$complaint,'$is_ready','$status_payment_id','$status_delivery_id')");
    }
}

?>