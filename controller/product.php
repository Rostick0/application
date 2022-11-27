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

    public static function addOrEditProducts($project_id, $products) {
        if (!is_array($products[0])) return;

        for ($i = 0; $i < count($products[0]); $i++) {
            $product_old = DbQuery::get('product', 'product_id', $products[17][$i])->fetch_assoc();
            $product_new = $product_old;

            if ($product_old) {
                if (!checkEdited($product_old['name'], $products[0][$i])) {
                    $product_new['name'] = $products[0][$i];
                    ProjectHistoryEditController::create('Изменил поле name', $product_old['name'], $products[0][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['track_number'], $products[1][$i])) {
                    $product_new['track_number'] = $products[1][$i];
                    ProjectHistoryEditController::create('Изменил поле track_number', $product_old['track_number'], $products[1][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['warehouse'], $products[2][$i])) {
                    $product_new['warehouse'] = $products[2][$i];
                    ProjectHistoryEditController::create('Изменил поле warehouse', $product_old['warehouse'], $products[2][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['address_from'], $products[3][$i])) {
                    $product_new['address_from'] = $products[3][$i];
                    ProjectHistoryEditController::create('Изменил поле address_from', $product_old['address_from'], $products[3][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['address_to'], $products[4][$i])) {
                    $product_new['address_to'] = $products[4][$i];
                    ProjectHistoryEditController::create('Изменил поле address_to', $product_old['address_to'], $products[4][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['count'], $products[5][$i])) {
                    $product_new['count'] = $products[5][$i];
                    ProjectHistoryEditController::create('Изменил поле count', $product_old['count'], $products[5][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['unit_measurement'], $products[6][$i])) {
                    $product_new['unit_measurement'] = $products[6][$i];
                    ProjectHistoryEditController::create('Изменил поле unit_measurement', $product_old['unit_measurement'], $products[6][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['price'], $products[7][$i])) {
                    $product_new['price'] = $products[7][$i];
                    ProjectHistoryEditController::create('Изменил поле price', $product_old['price'], $products[7][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['amount'], $products[8][$i])) {
                    $product_new['amount'] = $products[8][$i];
                    ProjectHistoryEditController::create('Изменил поле amount', $product_old['amount'], $products[8][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['purchase_price'], $products[9][$i])) {
                    $product_new['purchase_price'] = $products[9][$i];
                    ProjectHistoryEditController::create('Изменил поле purchase_price', $product_old['purchase_price'], $products[9][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['purchase_amount'], $products[10][$i])) {
                    $product_new['purchase_amount'] = $products[10][$i];
                    ProjectHistoryEditController::create('Изменил поле purchase_amount', $product_old['purchase_amount'], $products[10][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['status_delivery'], $products[11][$i])) {
                    $product_new['status_delivery'] = $products[11][$i];
                    ProjectHistoryEditController::create('Изменил поле status_delivery', $product_old['status_delivery'], $products[11][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['status_payment'], $products[12][$i])) {
                    $product_new['status_payment'] = $products[12][$i];
                    ProjectHistoryEditController::create('Изменил поле status_payment', $product_old['status_payment'], $products[12][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['document'], $products[13][$i])) {
                    $doc_file = [
                        'name' => $products[13]['name'][$i],
                        'type' => $products[13]['type'][$i],
                        'tmp_name' => $products[13]['tmp_name'][$i],
                        'error' => $products[13]['error'][$i],
                        'size' => $products[13]['size'][$i],
                    ];

                    $product_new['document'] = DocumentController::update($doc_file, $product_old['document']);
                    ProjectHistoryEditController::create('Изменил поле document', $product_old['document'], $products[13][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['link'], $products[14][$i])) {
                    $product_new['link'] = $products[14][$i];
                    ProjectHistoryEditController::create('Изменил поле link', $product_old['link'], $products[14][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['shipping_cost'], $products[15][$i])) {
                    $product_new['shipping_cost'] = $products[15][$i];
                    ProjectHistoryEditController::create('Изменил поле shipping_cost', $product_old['status_payment'], $products[15][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                if (!checkEdited($product_old['status_exploitation'], $products[16][$i])) {
                    $product_new['status_exploitation'] = $products[16][$i];
                    ProjectHistoryEditController::create('Изменил поле status_exploitation', $product_old['status_exploitation'], $products[16][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                }

                ProductController::update($product_new['product_id'], $product_new['name'], $product_new['track_number'], $product_new['warehouse'], $product_new['address_from'], $product_new['address_to'], $product_new['count'], $product_new['unit_measurement'], $product_new['price'], $product_new['amount'], $product_new['purchase_price'], $product_new['purchase_amount'], $product_new['status_delivery'], $product_new['status_payment'], $product_new['document'], $product_new['link'], $product_new['shipping_cost'], $product_new['status_exploitation']);

                continue;
            }

            $doc_file = [
                'name' => $products[13]['name'][$i],
                'type' => $products[13]['type'][$i],
                'tmp_name' => $products[13]['tmp_name'][$i],
                'error' => $products[13]['error'][$i],
                'size' => $products[13]['size'][$i],
            ];

            ProductController::create($products[0][$i], $products[1][$i], $products[2][$i], $products[3][$i], $products[4][$i], $products[5][$i], $products[6][$i], $products[7][$i], $products[8][$i], $products[9][$i], $products[10][$i], $products[11][$i], $products[12][$i], $doc_file, $products[14][$i], $products[15][$i], $products[16][$i], $project_id);
            ProjectHistoryEditController::create('Добавил товар ' . $products[0][$i], null, null, 'add', $project_id, $_SESSION['user']['user_id']);
        }
    }

    public static function addProducts($project_id, $products) {
        if (!is_array($products[0])) return;

        for ($i = 0; $i < count($products[0]); $i++) {
            $doc_file = [
                'name' => $products[13]['name'][$i],
                'type' => $products[13]['type'][$i],
                'tmp_name' => $products[13]['tmp_name'][$i],
                'error' => $products[13]['error'][$i],
                'size' => $products[13]['size'][$i],
            ];

            ProductController::create($products[0][$i], $products[1][$i], $products[2][$i], $products[3][$i], $products[4][$i], $products[5][$i], $products[6][$i], $products[7][$i], $products[8][$i], $products[9][$i], $products[10][$i], $products[11][$i], $products[12][$i], $doc_file, $products[14][$i], $products[15][$i], $products[16][$i], $project_id);
            ProjectHistoryEditController::create('Добавил товар ' . $products[0][$i], null, null, 'add', $project_id, $_SESSION['user']['user_id']);
        }
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