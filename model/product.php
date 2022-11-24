<?

class Product {
    public static function create($name, $track_number, $address_from, $address_to, $count, $unit_measurement,	$price, $amount, $purchase_price, $purchase_amount, $status_delivery = 1, $status_payment = 1, $project_id) {
        global $db_connect;

        $name = !empty($name) ? "'$name'" : "NULL";
        $track_number = !empty($track_number) ? "'$track_number'" : "NULL";
        $address_from = !empty($address_from) ? "'$address_from'" : "NULL";
        $address_to = !empty($address_to) ? "'$address_to'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $unit_measurement = !empty($unit_measurement) ? "'$unit_measurement'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $amount = !empty($amount) ? "'$amount'" : "NULL";
        $purchase_price = !empty($purchase_price) ? "'$purchase_price'" : "NULL";
        $purchase_amount = !empty($purchase_amount) ? "'$purchase_amount'" : "NULL";

        return $db_connect->query("INSERT INTO
        `product`(`name`, `track_number`,`address_from`, `address_to`,`count`, `unit_measurement`, `price`, `amount`, `purchase_price`, `purchase_amount`, `status_delivery`, `status_payment`, `project_id`)
        VALUES
        ($name,$track_number,$address_from,$address_to,$count,$unit_measurement,$price,$amount,$purchase_price,$purchase_amount,'$status_delivery','$status_payment','$project_id')");
    }

    public static function update($product_id, $name, $track_number, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery = 1, $status_payment = 1) {
        global $db_connect;

        $name = !empty($name) ? "'$name'" : "NULL";
        $track_number = !empty($track_number) ? "'$track_number'" : "NULL";
        $address_from = !empty($address_from) ? "'$address_from'" : "NULL";
        $address_to = !empty($address_to) ? "'$address_to'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $unit_measurement = !empty($unit_measurement) ? "'$unit_measurement'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $amount = !empty($amount) ? "'$amount'" : "NULL";
        $purchase_price = !empty($purchase_price) ? "'$purchase_price'" : "NULL";
        $purchase_amount = !empty($purchase_amount) ? "'$purchase_amount'" : "NULL";

        $query = $db_connect->query("UPDATE `product` SET
                    `name`=$name,`track_number`=$track_number,`address_from`=$address_from,`address_to`=$address_to,`count`=$count,`unit_measurement`=$unit_measurement,`price`=$price,`amount`=$amount,`purchase_price`=$purchase_price,`purchase_amount`=$purchase_amount,`status_delivery`='$status_delivery',`status_payment`='$status_payment'
                    WHERE `product_id` = '$product_id'");

        return $query;
    }

    public static function delete($product_id) {
        global $db_connect;

        $query = $db_connect->query("DELETE FROM `product` WHERE `product_id` = '$product_id'");

        return $query;
    }
}

?>