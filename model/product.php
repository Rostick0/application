<?

class Product {
    public static function create($name, $address_from, $address_to, $count, $unit_measurement,	$price, $amount, $purchase_price, $purchase_amount, $status_delivery = 1, $status_payment = 1, $project_id) {
        global $db_connect;

        $name = !empty($name) ? "'$name'" : "NULL";
        $address_from = !empty($address_from) ? "'$address_from'" : "NULL";
        $address_to = !empty($address_to) ? "'$address_to'" : "NULL";
        $count = !empty($count) ? "'$count'" : "NULL";
        $unit_measurement = !empty($unit_measurement) ? "'$unit_measurement'" : "NULL";
        $price = !empty($price) ? "'$price'" : "NULL";
        $amount = !empty($amount) ? "'$amount'" : "NULL";
        $purchase_price = !empty($purchase_price) ? "'$purchase_price'" : "NULL";
        $purchase_amount = !empty($purchase_amount) ? "'$purchase_amount'" : "NULL";

        return $db_connect->query("INSERT INTO
        `product`(`name`, `address_from`, `address_to`,`count`, `unit_measurement`, `price`, `amount`, `purchase_price`, `purchase_amount`, `status_delivery`, `status_payment`, `project_id`)
        VALUES
        ($name,$address_from,$address_to,$count,$unit_measurement,$price,$amount,$purchase_price,$purchase_amount,'$status_delivery','$status_payment','$project_id')");
    }
}

?>