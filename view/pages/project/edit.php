<?

$project_id = (int) $_GET['id'];

$project = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

if (!$project) {
    header('Location: /project/create');
}

$users = DbQuery::get('user');
$zmo = DbQuery::get('zmo');
$status_delivery = DbQuery::get('status_delivery');
$status_payment = DbQuery::get('status_payment');
$status_exploitation = DbQuery::get('status_exploitation');

$is_made_order = $_REQUEST['project_is_made_order'];
$documents = $_REQUEST['project_documents'];
$document_scan = $_REQUEST['project_document_scan'];
$name = $_REQUEST['project_name'];
$address = NULL;
$inn = $_REQUEST['project_inn'];
$contract = $_REQUEST['project_contract'];
$zmo_id = $_REQUEST['project_zmo'];
$start_date = $_REQUEST['project_start_date'];
$end_date = $_REQUEST['project_end_date'];
$comment = $_REQUEST['project_comment'];
$complaint = $_REQUEST['project_complaint'];

$is_ready = $_REQUEST['project_is_ready'];

$button_edit = $_REQUEST['button_edit'];

$my_access = ProjectAccessController::getMy($project_id)->fetch_assoc();
$my_acces_array = json_decode($my_access['name'], true);
$my_acces_array = $my_acces_array ? $my_acces_array : [];

$products = DbQuery::get('product', 'project_id', $project_id);

$products_new = [];
$can_interaction_product = false;

if ((array_search('all', $my_acces_array) !== false) || array_search('product', $my_acces_array) !== false) {
    $can_interaction_product = true;

    $products_new = [
        $_REQUEST['product_name'],
        $_REQUEST['product_track_number'],
        $_REQUEST['product_address_from'],
        $_REQUEST['product_address_to'],
        $_REQUEST['product_count'],
        $_REQUEST['product_unit_measurement'],
        $_REQUEST['product_price'],
        $_REQUEST['product_amount'],
        $_REQUEST['product_purchase_price'],
        $_REQUEST['product_purchase_amount'],
        $_REQUEST['product_status_delivery'],
        $_REQUEST['product_status_payment'],
        $_FILES['product_document'],
        $_REQUEST['product_link'],
        $_REQUEST['product_shipping_cost'],
        $_REQUEST['product_status_exploitation'],
        $_REQUEST['product_id'],
    ];
}

if (isset($button_edit)) {
    $error = ProjectController::edit($project_id, $name, $contract, $address, $inn, $start_date, $end_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, $products_new, $my_acces_array);

    if (!$error) {
        $error = ProjectController::setReady($project_id, $is_ready);
    }
}

$button_delete = $_REQUEST['button_delete'];

if (isset($button_delete)) {
    $error = ProjectController::delete($project_id, $my_acces_array);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Редактирование проекта</title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <div class="container">
                <div class="project__container">
                    <? if ($error) : ?>
                        <p class="project__form_error red-text text-darken-1">
                            <?= $error ?>
                        </p>
                    <? endif; ?>
                    <form class="col s12 project__form" method="POST" enctype="multipart/form-data">
                        <div class="project__flex">
                            <? if (array_search('is_made_order', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                <label class="project__is-ready">
                                    <input type="checkbox" class="filled-in" name="project_is_made_order" <?= $project['is_made_order'] ? 'checked' : '' ?>>
                                    <span class="project__is-ready_text">
                                        <span class="project__is-ready_text">
                                            Заказ сделан?
                                        </span>
                                    </span>
                                </label>
                            <? else : ?>
                                <strong>
                                    Заказ сделан?
                                </strong>
                                <p>
                                    <?= $project['is_made_order'] ? 'Да' : 'Нет' ?>
                                </p>
                            <? endif; ?>
                            <? if (array_search('documents', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                <label class="project__is-ready">
                                    <input type="checkbox" class="filled-in" name="project_documents" <?= $project['documents'] ? 'checked' : '' ?>>
                                    <span class="project__is-ready_text">
                                        <span class="project__is-ready_text">
                                            Документы готовы?
                                        </span>
                                    </span>
                                </label>
                            <? else : ?>
                                <strong>
                                    Документы готовы?
                                </strong>
                                <p>
                                    <?= $project['documents'] ? 'Да' : 'Нет' ?>
                                </p>
                            <? endif; ?>
                        </div>
                        <div class="project__flex">
                            <? if (array_search('document_scan', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                <label class="project__is-ready">
                                    <input type="checkbox" class="filled-in" name="project_document_scan" <?= $project['document_scan'] ? 'checked' : '' ?>>
                                    <span class="project__is-ready_text">
                                        <span class="project__is-ready_text">
                                            Скан документов готов?
                                        </span>
                                    </span>
                                </label>
                            <? else : ?>
                                <strong>
                                    Скан документов готов?
                                </strong>
                                <p>
                                    <?= $project['document_scan'] ? 'Да' : 'Нет' ?>
                                </p>
                            <? endif; ?>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <? if (array_search('name', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate" id="project_name" type="text" name="project_name" value="<?= $project['name'] ?>">
                                    <label for="project_name">Название*</label>
                                <? else : ?>
                                    <strong>
                                        Название
                                    </strong>
                                    <p>
                                        <?= $project['name'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                            <div class="input-field col s12">
                                <? if (array_search('inn', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate" id="project_inn" type="number" name="project_inn" value="<?= $project['inn'] ?>">
                                    <label for="project_inn">ИНН*</label>
                                <? else : ?>
                                    <strong>
                                        ИНН
                                    </strong>
                                    <p>
                                        <?= $project['inn'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                            <div class="input-field col s12">
                                <? if (array_search('contract', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate" id="project_contract" type="number" name="project_contract" value="<?= $project['contract'] ?>">
                                    <label for="project_contract">Номер договора</label>
                                <? else : ?>
                                    <strong>
                                        Номер договора
                                    </strong>
                                    <p>
                                        <?= $project['contract'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <? if (array_search('zmo_id', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <select name="project_zmo">
                                        <? foreach ($zmo as $value) : ?>
                                            <option value="<?= $value['zmo_id'] ?>" <?= $project['zmo_id'] == $value['zmo_id'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                    <label>ЗМО</label>
                                <? else : ?>
                                    <strong>
                                        ЗМО
                                    </strong>
                                    <p>
                                        <?= DbQuery::parse('zmo', 'zmo_id', $project['zmo_id']) ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <? if (array_search('start_date', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date" value="<?= DateEditor::normalizeDate($project['start_date'], true) ?>" readonly>
                                    <label for="project_start_date">Дата начала контракта*</label>
                                <? else : ?>
                                    <strong>
                                        Дата начала контракта
                                    </strong>
                                    <p>
                                        <?= DateEditor::normalizeDate($project['start_date'], true) ?>
                                    </p>
                                <? endif; ?>
                            </div>
                            <div class="input-field col s12">
                                <? if (array_search('end_date', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date" value="<?= DateEditor::normalizeDate($project['end_date'], true) ?>" readonly>
                                    <label for="project_end_date">Дата окончания контракта*</label>
                                <? else : ?>
                                    <strong>
                                        Дата окончания контракта
                                    </strong>
                                    <p>
                                        <?= DateEditor::normalizeDate($project['end_date'], true) ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <div class="input-field col s12">
                                <? if (array_search('comment', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <textarea class="materialize-textarea" id="project_comment" name="project_comment"><?= $project['comment'] ?></textarea>
                                    <label for="project_comment">Комментарий</label>
                                <? else : ?>
                                    <strong>
                                        Комментарий
                                    </strong>
                                    <p>
                                        <?= $project['comment'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <div class="input-field col s12">
                                <? if (array_search('complaint', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <textarea class="materialize-textarea" id="project_complaint" name="project_complaint"><?= $project['complaint'] ?></textarea>
                                    <label for="project_complaint">Замечания</label>
                                <? else : ?>
                                    <strong>
                                        Замечания
                                    </strong>
                                    <p>
                                        <?= $project['complaint'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <? if ($can_interaction_product) : ?>
                            <? foreach ($products as $product) : ?>
                                <div class="project__flex project__product">
                                    <input type="text" name="product_id[]" value="<?= $product['product_id'] ?>" hidden>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_name_<?= $product['product_id'] ?>" type="text" name="product_name[]" value="<?= $product['name'] ?>">
                                        <label for="product_name_<?= $product['product_id'] ?>">Наименование</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_track_number_<?= $product['track_number'] ?>" type="number" name="product_track_number[]">
                                        <label for="product_track_number_<?= $product['track_number'] ?>">Трек номер</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_address_from_<?= $product['product_id'] ?>" type="text" name="product_address_from[]" value="<?= $product['address_from'] ?>">
                                        <label for="product_address_from_<?= $product['product_id'] ?>">Откуда</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_address_too_<?= $product['product_id'] ?>" type="text" name="product_address_to[]" value="<?= $product['address_to'] ?>">
                                        <label for="product_address_too_<?= $product['product_id'] ?>">Куда</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_count_<?= $product['product_id'] ?>" type="number" name="product_count[]" step="0.001" value="<?= $product['count'] ?>">
                                        <label for="product_count_<?= $product['product_id'] ?>">Количество*</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_unit_measurement_<?= $product['product_id'] ?>" type="text" name="product_unit_measurement[]" value="<?= $product['unit_measurement'] ?>">
                                        <label for="product_unit_measurement_<?= $product['product_id'] ?>">ед. из</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_price_<?= $product['product_id'] ?>" type="number" name="product_price[]" step="0.001" value="<?= $product['price'] ?>">
                                        <label for="product_price_<?= $product['product_id'] ?>">Цена</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_amount_<?= $product['product_id'] ?>" type="number" name="product_amount[]" step="0.001" value="<?= $product['amount'] ?>">
                                        <label for="product_amount_<?= $product['product_id'] ?>">Сумма</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_purchase_price_<?= $product['product_id'] ?>" type="number" name="product_purchase_price[]" step="0.001" value="<?= $product['purchase_price'] ?>">
                                        <label for="product_purchase_price_<?= $product['product_id'] ?>">Цена закупа</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_purchase_amount_<?= $product['product_id'] ?>" type="number" name="product_purchase_amount[]" step="0.001" value="<?= $product['purchase_amount'] ?>">
                                        <label for="product_purchase_amount_<?= $product['product_id'] ?>">Сумма закупа</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="product_status_delivery[]">
                                            <? foreach ($status_delivery as $value) : ?>
                                                <option value="<?= $value['status_delivery_id'] ?>" <?= $value['status_delivery_id'] == $product['status_delivery'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                        <label>
                                            Статус доставка
                                        </label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="product_status_payment[]">
                                            <? foreach ($status_payment as $value) : ?>
                                                <option value="<?= $value['status_payment_id'] ?>" <?= $value['status_payment_id'] == $product['status_payment'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                        <label>
                                            Статус оплаты
                                        </label>
                                    </div>
                                    <div class="file-field input-field">
                                        <div class="btn">
                                            <span>File</span>
                                            <input type="file" name="product_document[]">
                                        </div>
                                        <div class="file-path-wrapper">
                                            <input class="file-path validate" type="text" value="<?= $product['document'] ?>">
                                        </div>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_link_<?= $product['link'] ?>" type="text" name="product_link[]" value="<?= $product['name'] ?>">
                                        <label for="product_link_<?= $product['link'] ?>">Ссылка на товар</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <input class="validate" id="product_shipping_cost_<?= $product['shipping_cost'] ?>" type="number" name="product_shipping_cost[]" value="<?= $product['shipping_cost'] ?>" step="0.001">
                                        <label for="product_shipping_cost_<?= $product['shipping_cost'] ?>">Стоимость доставки</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="product_status_exploitation[]">
                                            <? foreach ($status_exploitation as $value) : ?>
                                                <option value="<?= $value['status_exploitation_id'] ?>" <?= $value['status_exploitation_id'] == $product['status_exploitation'] ? 'selected' : '' ?>><?= $value['name'] ?></option>
                                            <? endforeach; ?>
                                        </select>
                                        <label>
                                            Статус доставка
                                        </label>
                                    </div>
                                    <div class="input-field col s12">
                                        <button class="waves-effect waves-light btn-large red darken-1" name="button_delete_<?= $product['product_id'] ?>">
                                            Удалить
                                        </button>
                                    </div>
                                    <?
                                    if (isset($_REQUEST["button_delete_{$product['product_id']}"])) {
                                        ProductController::delete($product['product_id'], $project_id);

                                        echo '<meta http-equiv="refresh" content="0">';
                                    }
                                    ?>
                                </div>
                            <? endforeach ?>
                        <? else : ?>
                            <? foreach ($products as $product) : ?>
                                <div class="project__flex project__product">
                                    <div class="input-field col s12">
                                        <strong>
                                            Наименование
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['name']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Трек номера
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['track_number']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Откуда
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['address_from']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Куда
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['address_to']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Количество
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['count']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            ед. из
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['unit_measurement']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Цена
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['price']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Сумма
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['amount']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Цена закупа
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['purchase_price']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Сумма закупа
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['purchase_amount']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Статус доставка
                                        </strong>
                                        <p>
                                            <?= DbQuery::parse('status_delivery', 'status_delivery_id', $product['status_delivery']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Статус оплаты
                                        </strong>
                                        <p>
                                            <?= DbQuery::parse('status_payment', 'status_payment_id', $product['status_payment']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Ссылка на документ
                                        </strong>
                                        <? if ($product['document']) : ?>
                                            <a href="<?= $PATH_UPLOAD . $product['document'] ?>">
                                                Открыть
                                            </a>
                                        <? endif ?>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Ссылка на товар
                                        </strong>
                                        <? if ($product['link']) : ?>
                                            <a href="<?= $PATH_UPLOAD . $product['link'] ?>">
                                                Открыть
                                            </a>
                                        <? endif ?>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Стоимость доставки
                                        </strong>
                                        <p>
                                            <?= HtmlDom::checkData($product['shipping_cost']) ?>
                                        </p>
                                    </div>
                                    <div class="input-field col s12">
                                        <strong>
                                            Ввод в эксплуатацию
                                        </strong>
                                        <p>
                                            <?= DbQuery::parse('status_exploitation', 'status_exploitation_id', $product['status_exploitation']) ?>
                                        </p>
                                    </div>
                                </div>
                            <? endforeach ?>
                        <? endif ?>
                        <? if ($can_interaction_product) : ?>
                            <div class="project__button project__button_add">
                                <button class="waves-effect waves-light btn-large blue darken-1 product_add">
                                    Добавить товар
                                </button>
                            </div>
                        <? endif; ?>
                        <? if (array_search('add_people', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                            <div class="project__button project__button_add">
                                <a class="waves-effect waves-light btn-large blue darken-1 product_add" href="/project/users?project_id=<?= $project_id ?>">
                                    Добавить человека
                                </a>
                            </div>
                        <? endif ?>
                        <div class="project__button">
                            <label class="project__is-ready">
                                <input type="checkbox" class="filled-in" name="project_is_ready" <?= $project['is_ready'] == 1 ? 'checked' : '' ?>>
                                <span class="project__is-ready_text">
                                    <span class="project__is-ready_text">
                                        Заказ готов?
                                    </span>
                                </span>
                            </label>
                        </div>
                        <div class="project__button">
                            <div class="project__button_inner">
                                <button class="waves-effect waves-light btn-large blue darken-1" name="button_edit">
                                    Изменить
                                </button>
                                <? if (array_search('project_delete', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <button class="waves-effect waves-light btn-large red darken-1" name="button_delete">
                                        Удалить
                                    </button>
                                <? endif ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>