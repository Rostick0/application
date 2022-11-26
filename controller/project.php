<?

class ProjectController
{
    public static function get($status_date, $limit, $offset, $type = null) {
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $limit = (int) $limit;
        $offset = (int) $offset;
        
        if ($type == 'count') {
            return Project::getCount($status_date);
        }

        return Project::get($status_date, $limit, $offset);
    }

    public static function search($name, $project_id, $status_date, $limit, $offset, $type = null) {
        $name = DbQuery::protectedData($name);
        $project_id = (int) $project_id;
        $status_date = implode(', ', DbQuery::setIntInArray($status_date));
        $limit = (int) $limit;
        $offset = (int) $offset;

        if ($type == 'count') {
            return Project::searchCount($name, $project_id, $status_date);
        }

        return Project::search($name, $project_id, $status_date, $limit, $offset);
    }

    public static function getMy($limit, $offset)
    {
        $user_id = (int) $_SESSION['user']['user_id'];
        $limit = (int) $limit;
        $offset = (int) $offset;

        return Project::getMy($user_id, $limit, $offset);
    }

    public static function create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready = 0, $products)
    {
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = DateEditor::normalizeDateSql($start_date);
        $end_date = DateEditor::normalizeDateSql($end_date);
        $delivery_date = DateEditor::normalizeDateSql($delivery_date);
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $documents = $documents ? 1 : 0;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $is_ready = $is_ready ? 1 : 0;

        if (strlen($name) < 3) return "Название компании меньше 3 символов";

        if (!$inn) return "Отсуствует ИНН";

        $user_role = DbQuery::parse('user', 'user_id', $_SESSION['user']['user_id'], 'role_id');

        $user_power = DbQuery::parse('role', 'role_id', $user_role, 'power');

        if ($user_power < 25) return "Создание недоступно для вас";

        $project_id = Project::create($name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $is_ready);
        ProjectAccessController::create($project_id, json_encode(['all']), $_SESSION['user']['user_id']);
        ProjectHistoryEditController::create('Создал проект ' . $project_id, null, null, 'create', $project_id, $_SESSION['user']['user_id']);

        if ($delivery_date) {
            ProjectController::setStatusDate($project_id, $delivery_date, $is_ready);
        }

        if (!is_array($products[0])) return;

        for ($i = 0; $i < count($products[0]); $i++) {
            $doc_file = [
                'name' => $products[13]['name'][$i],
                'type' => $products[13]['type'][$i],
                'tmp_name' => $products[13]['tmp_name'][$i],
                'error' => $products[13]['error'][$i],
                'size' => $products[13]['size'][$i],
            ];

            $doc = DocumentController::upload($doc_file);

            ProductController::create($products[0][$i], $products[1][$i], $products[2][$i], $products[3][$i], $products[4][$i], $products[5][$i], $products[6][$i], $products[7][$i], $products[8][$i], $products[9][$i], $products[10][$i], $products[11][$i], $products[12][$i], $doc, $products[14][$i], $products[15][$i], $products[16][$i], $project_id);
            ProjectHistoryEditController::create('Добавил товар ' . $products[0][$i], null, null, 'add', $project_id, $_SESSION['user']['user_id']);
        }

        header('Refresh: 0');
    }

    public static function edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $delivery_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $products, $access_array)
    {
        $project_id = (int) $project_id;
        $name = DbQuery::protectedData($name);
        $contract = DbQuery::protectedData($contract);
        $address = DbQuery::protectedData($address);
        $inn = (int) $inn;
        $start_date = $start_date ? DateEditor::normalizeDateSql($start_date) : "";
        $end_date = $end_date ? DateEditor::normalizeDateSql($end_date) : "";
        $delivery_date = $delivery_date ? DateEditor::normalizeDateSql($delivery_date) : "";
        $comment = DbQuery::protectedData($comment);
        $complaint = DbQuery::protectedData($complaint);
        $zmo_id = (int) $zmo_id;
        $is_made_order = $is_made_order ? 1 : 0;
        $document_scan = $document_scan ? 1 : 0;
        $documents = $documents ? 1 : 0;

        $data_type = compact(
            'name',
            'contract',
            'inn',
            'start_date',
            'end_date',
            'delivery_date',
            'comment',
            'complaint',
            'zmo_id',
            'is_made_order',
            'document_scan',
            'documents'
        );

        $project_old = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $action_edit = [];

        $user_power = (int) DbQuery::parse('role', 'role_id', $_SESSION['user']['role_id'], 'power');

        foreach ($data_type as $type => $value) {
            if ($access_array[0] != 'all' || $user_power < 20) {
                if (!ProjectAccessController::check($value, $type, $access_array)) {
                    $data_type[$type] = $project_old[$type];
                    continue;
                }
            }

            if (!ProjectController::checkEdited($project_old[$type], $data_type[$type])) {
                $action_edit[] = [
                    'name' => $type,
                    'old' => DbQuery::protectedData($project_old[$type]),
                    'new' => DbQuery::protectedData($data_type[$type])
                ];
            }
        }

        if (strlen($data_type['name']) < 3) return "Название компании меньше 3 символов";

        if (!$data_type['inn']) return "Отсуствует ИНН";

        $query = Project::edit($project_id, $data_type['name'], $data_type['contract'], $data_type['address'], $data_type['inn'], $data_type['start_date'], $data_type['end_date'], $data_type['delivery_date'], $data_type['comment'], $data_type['complaint'], $data_type['zmo_id'], $data_type['is_made_order'], $data_type['document_scan'], $data_type['documents']);

        if (!$query) return "Ошибка при изменении данных";

        if ($data_type['delivery_date'] == $delivery_date) {
            ProjectController::setStatusDate($project_id, $data_type['delivery_date'], $data_type['is_ready']);
        }

        if (count($action_edit) > 1) {
            foreach ($action_edit as $action) {
                ProjectHistoryEditController::create('Изменил поле ' . $action['name'], $action['old'], $action['new'], 'edit', $project_id, $_SESSION['user']['user_id']);
            }
        }

        if (is_array($products[0])) {
            for ($i = 0; $i < count($products[0]); $i++) {
                $product_old = DbQuery::get('product', 'product_id', $products[17][$i])->fetch_assoc();
                $product_new = $product_old;

                if ($product_old) {
                    if (!ProjectController::checkEdited($product_old['name'], $products[0][$i])) {
                        $product_new['name'] = $products[0][$i];
                        ProjectHistoryEditController::create('Изменил поле name', $product_old['name'], $products[0][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['track_number'], $products[1][$i])) {
                        $product_new['track_number'] = $products[1][$i];
                        ProjectHistoryEditController::create('Изменил поле track_number', $product_old['track_number'], $products[1][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['warehouse'], $products[2][$i])) {
                        $product_new['warehouse'] = $products[2][$i];
                        ProjectHistoryEditController::create('Изменил поле warehouse', $product_old['warehouse'], $products[2][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['address_from'], $products[3][$i])) {
                        $product_new['address_from'] = $products[3][$i];
                        ProjectHistoryEditController::create('Изменил поле address_from', $product_old['address_from'], $products[3][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['address_to'], $products[4][$i])) {
                        $product_new['address_to'] = $products[4][$i];
                        ProjectHistoryEditController::create('Изменил поле address_to', $product_old['address_to'], $products[4][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['count'], $products[5][$i])) {
                        $product_new['count'] = $products[5][$i];
                        ProjectHistoryEditController::create('Изменил поле count', $product_old['count'], $products[5][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['unit_measurement'], $products[6][$i])) {
                        $product_new['unit_measurement'] = $products[6][$i];
                        ProjectHistoryEditController::create('Изменил поле unit_measurement', $product_old['unit_measurement'], $products[6][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['price'], $products[7][$i])) {
                        $product_new['price'] = $products[7][$i];
                        ProjectHistoryEditController::create('Изменил поле price', $product_old['price'], $products[7][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['amount'], $products[8][$i])) {
                        $product_new['amount'] = $products[8][$i];
                        ProjectHistoryEditController::create('Изменил поле amount', $product_old['amount'], $products[8][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['purchase_price'], $products[9][$i])) {
                        $product_new['purchase_price'] = $products[9][$i];
                        ProjectHistoryEditController::create('Изменил поле purchase_price', $product_old['purchase_price'], $products[9][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['purchase_amount'], $products[10][$i])) {
                        $product_new['purchase_amount'] = $products[10][$i];
                        ProjectHistoryEditController::create('Изменил поле purchase_amount', $product_old['purchase_amount'], $products[10][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['status_delivery'], $products[11][$i])) {
                        $product_new['status_delivery'] = $products[11][$i];
                        ProjectHistoryEditController::create('Изменил поле status_delivery', $product_old['status_delivery'], $products[11][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['status_payment'], $products[12][$i])) {
                        $product_new['status_payment'] = $products[12][$i];
                        ProjectHistoryEditController::create('Изменил поле status_payment', $product_old['status_payment'], $products[12][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['document'], $products[13][$i])) {
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

                    if (!ProjectController::checkEdited($product_old['link'], $products[14][$i])) {
                        $product_new['link'] = $products[14][$i];
                        ProjectHistoryEditController::create('Изменил поле link', $product_old['link'], $products[14][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['shipping_cost'], $products[15][$i])) {
                        $product_new['shipping_cost'] = $products[15][$i];
                        ProjectHistoryEditController::create('Изменил поле shipping_cost', $product_old['status_payment'], $products[15][$i], 'edit', $project_id, $_SESSION['user']['user_id']);
                    }

                    if (!ProjectController::checkEdited($product_old['status_exploitation'], $products[16][$i])) {
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

        // header('Refresh: 0');
    }

    public static function setReady($project_id, $is_ready)
    {
        $project_id = (int) $project_id;
        $is_ready = $is_ready ? 1 : 0;

        if ($is_ready == 0) {
            Project::setReady($project_id, $is_ready);
            return;
        }

        $project_data = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

        $error_text = "Нельзя сделать проект готовым, пока ";

        if (strlen($project_data['name']) < 3) return $error_text . "название компании меньше 3 символов";

        if (!$project_data['inn']) return $error_text . "Отсуствует ИНН";

        Project::setReady($project_id, $is_ready);
    }

    public static function checkEdited($old, $new)
    {
        if (is_null($old) && is_null($new)) return false;

        return $old == $new;
    }

    public static function setStatusDate($project_id, $date_delivery, $is_ready)
    {
        if ($is_ready) return;

        if (!$date_delivery) return;

        $status_date = 1;
        $today = strtotime(date('y-m-d'));

        if ((strtotime($date_delivery)) - $today <= 172800) {
            $status_date = 2;
        }

        if (strtotime($date_delivery) < $today) {
            $status_date = 3;
        }

        Project::setStatusDate($project_id, $status_date);
    }

    public static function checkDate($start_date, $is_ready)
    {
        if ($is_ready) return 'green lighten-3';

        if (!$start_date) return;

        if (time() - (strtotime($start_date)) / 60 * 60 * 24 * 2 <= 2) return 'yellow lighten-3';

        return 'red lighten-3';
    }

    public static function colorProject($delivery_status, $is_ready)
    {
        if ($is_ready) return 'green lighten-3';

        if (!$delivery_status) return;

        if ($delivery_status == 2) return 'yellow lighten-3';

        if ($delivery_status == 3) return 'red lighten-3';
    }

    public static function delete($project_id, $access_array)
    {
        $project_id = (int) $project_id;

        $user_power = (int) DbQuery::parse('role', 'role_id', $_SESSION['user']['role_id'], 'power');

        if ($access_array[0] != 'all' || $user_power < 20 || array_search('project_delete', $access_array) !== false) return "Ошибка при удалении";

        $query = Project::delete($project_id);

        if (!$query) return "Ошибка при удалении";

        ProjectHistoryEditController::create('Удалил проект ' . $project_id, null, null, 'delete', $project_id, $_SESSION['user']['user_id']);
        header('Location: /');
    }
}

?>