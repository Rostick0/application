<?

class ProductController {
    public static function create($name, $track_number, $address_from, $address_to, $count, $unit_measurement,	$price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $project_id) {
        $name = DbQuery::protectedData($name);
        $track_number = DbQuery::protectedData($track_number);
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
        
        Product::create($name, $track_number, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $project_id);
    }

    public static function update($product_id, $name, $track_number, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment) {
        $product_id = (int) $product_id;
        $name = DbQuery::protectedData($name);
        $track_number = DbQuery::protectedData($track_number);
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

        Product::update($product_id, $name, $track_number, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment);
    }

    public static function delete($product_id, $project_id) {
        $product_id = (int) $product_id;
        $project_id = (int) $project_id;

        $query = Product::delete($product_id);

        if (!$query) return;

        ProjectHistoryEditController::create('Удалён товар', null, null, 'delete', $project_id, $_SESSION['user']['user_id']);
    }
}

?>