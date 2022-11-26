<?

class ProductController {
    public static function create($name, $track_number, $warehouse, $address_from, $address_to, $count, $unit_measurement,	$price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $document, $link, $shipping_cost, $status_exploitation, $project_id) {
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
        $link = DbQuery::protectedData($link);
        $shipping_cost = (float) $shipping_cost;
        $status_exploitation = (int) $status_exploitation;

        if (is_array($document)) $document = null;
        
        Product::create($name, $track_number, $warehouse, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $document, $link, $shipping_cost, $status_exploitation, $project_id);
    }

    public static function update($product_id, $name, $track_number, $warehouse, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $document, $link, $shipping_cost, $status_exploitation) {
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
        $link = DbQuery::protectedData($link);
        $shipping_cost = (float) $shipping_cost;
        $status_exploitation = (int) $status_exploitation;

        if (is_array($document)) $document = null;

        Product::update($product_id, $name, $track_number, $warehouse, $address_from, $address_to, $count, $unit_measurement, $price, $amount, $purchase_price, $purchase_amount, $status_delivery, $status_payment, $document, $link, $shipping_cost, $status_exploitation);
    }

    public static function delete($product_id, $project_id) {
        $product_id = (int) $product_id;
        $project_id = (int) $project_id;

        $product_document = DbQuery::parse('product', 'product_id', $product_id, 'document');

        $query = Product::delete($product_id);

        if (!$query) return;

        DocumentController::delete($product_document);
        ProjectHistoryEditController::create('Удалён товар', null, null, 'delete', $project_id, $_SESSION['user']['user_id']);
    }
}

?>