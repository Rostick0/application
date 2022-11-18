<?

class Project {
    public static function create($name, $address, $inn, $start_date, $end_date, $count, $price, $price_commission, $comment, $is_ready, $status_payment_id, $status_delivery_id) {
        global $db_connect;

        $comment = !empty($comment) ? "'$comment'" : "NULL";

        return $db_connect->query("INSERT INTO
            `project` (`name`, `address`, `inn`, `start_date`, `end_date`, `count`, `price`, `price_commission`, `comment`, `is_ready`, `status_payment_id`, `status_delivery_id`)
                VALUES
            ('$name','$address','$inn','$start_date','$end_date','$count','$price','$price_commission',$comment,'$is_ready','$status_payment_id','$status_delivery_id')");
    }
}

?>