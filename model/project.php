<?

class Project {
    public static function create($name, $address, $inn, $start_date, $end_date, $count, $price, $price_commission, $comment = null, $is_ready = 0, $status_payment_id = 1, $status_delivery_id = 1) {
        global $db_connect;

        $comment = !empty($comment) ? "'$comment'" : "NULL";

        return $db_connect->query("INSERT INTO
            `project` (`name`, `address`, `inn`, `start_date`, `end_date`, `count`, `price`, `price_commission`, `comment`, `is_ready`, `status_payment_id`, `status_delivery_id`)
                VALUES
            ('$name','$address','$inn','$start_date','$end_date','$count','$price','$price_commission',$comment,'$is_ready','$status_payment_id','$status_delivery_id')");
    }
}

?>