<?

class ProductController {
    public static function create($name, $address_from, $address_to, $count, $unit_measurement,	$price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $project_id) {
        $name = DbQuery::protectedData($name);
        $address_from = DbQuery::protectedData($address_from);
        $address_to = DbQuery::protectedData($address_to);
        $count = (float) $count;
        $unit_measurement = DbQuery::protectedData($unit_measurement);
        $price = (float) $price;
        $amount = (float) $amount;
        $purchase_price = (float) $purchase_price;
        $purchase_amount = (float) $purchase_amount;
        $status_delivery = (int) $status_delivery;
        $status_payment = (int) $status_payment;
        $project_id = (int) $project_id;
        
        Product::create($name, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $project_id);
    }
}

?>