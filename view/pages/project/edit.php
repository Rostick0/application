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

var_dump($project);

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

$button_create = $_REQUEST['button_create'];

$my_access = ProjectAccessController::getMy($project_id)->fetch_assoc();
$my_acces_array = json_decode($my_access['name'], true);

$products = [
    $_REQUEST['product_name'],
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
];

if (isset($button_create)) {
    // $error = ProjectController::create($name, $contract, $address, $inn, $start_date, $end_date, $comment, $complaint, $zmo_id, $is_made_order, $document_scan, $documents, 0, $products);
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Создание проекта</title>
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
                    <form class="col s12 project__form" method="POST">
                        <div class="project__flex">
                            <? if (array_search('is_made_order', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                <label class="project__is-ready">
                                    <input type="checkbox" class="filled-in" name="project_is_made_order">
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
                                    <input type="checkbox" class="filled-in" name="project_documents">
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
                                    <input type="checkbox" class="filled-in" name="project_document_scan">
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
                                <? if (array_search('manager', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <select name="project_manager">
                                        <? foreach ($users as $value) : ?>
                                            <option value="<?= $value['user_id'] ?>"><?= $value['email'] ?></option>
                                        <? endforeach; ?>
                                    </select>
                                    <label>Выбрать менеджера</label>
                                <? else : ?>
                                    <strong>
                                        Менеджер
                                    </strong>
                                    <p>
                                        Пока в разработке
                                    </p>
                                <? endif; ?>
                            </div>
                            <div class="input-field col s12">
                                <? if (array_search('name', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate" id="project_name" type="text" name="project_name">
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
                                    <label for="project_contract">Договор</label>
                                <? else : ?>
                                    <strong>
                                        Договор
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
                                            <option value="<?= $value['zmo_id'] ?>"><?= $value['name'] ?></option>
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
                                    <input class="validate datepicker" id="project_start_date" type="text" name="project_start_date" value="<?= DateEditor::normalizeDate($start_date, true) ?>" readonly>
                                    <label for="project_start_date">Дата начала*</label>
                                <? else : ?>
                                    <strong>
                                        Дата начала
                                    </strong>
                                    <p>
                                        <?= DateEditor::normalizeDate($start_date, true) ?>
                                    </p>
                                <? endif; ?>
                            </div>
                            <div class="input-field col s12">
                                <? if (array_search('end_date', $my_acces_array) !== false || (array_search('all', $my_acces_array) !== false)) : ?>
                                    <input class="validate datepicker" id="project_end_date" type="text" name="project_end_date" value="<?= DateEditor::normalizeDate($end_date, true) ?>" readonly>
                                    <label for="project_end_date">Дата окончания*</label>
                                <? else : ?>
                                    <strong>
                                        Дата начала
                                    </strong>
                                    <p>
                                        <?= DateEditor::normalizeDate($end_date, true) ?>
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
                                        Комментарий
                                    </strong>
                                    <p>
                                        <?= $project['complaint'] ?>
                                    </p>
                                <? endif; ?>
                            </div>
                        </div>
                        <div class="project__button project__button_add">
                            <button class="waves-effect waves-light btn-large blue darken-1 product_add">
                                Добавить товар
                            </button>
                        </div>
                        <div class="project__button">
                            <button class="waves-effect waves-light btn-large blue darken-1" name="button_create">
                                Изменить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let count_created = 0;

        const productHtml = `
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <input class="validate" id="product_name_${count_created}" type="text" name="product_name[]">
                                <label for="product_name_${count_created}">Наименование*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_from_${count_created}" type="number" name="product_address_from[]">
                                <label for="product_address_from_${count_created}">Количество*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_address_too_${count_created}" type="number" name="product_address_to[]">
                                <label for="product_address_too_${count_created}">Количество*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_count_${count_created}" type="number" name="product_count[]">
                                <label for="product_count_${count_created}">Количество*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_unit_measurement_${count_created}" type="text" name="product_unit_measurement[]">
                                <label for="product_unit_measurement_${count_created}">ед. из</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_price_${count_created}" type="number" name="product_price[]">
                                <label for="product_price_${count_created}">Цена*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_amount_${count_created}" type="number" name="product_amount[]">
                                <label for="product_amount_${count_created}">Сумма*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_price_${count_created}" type="number" name="product_purchase_price[]">
                                <label for="product_purchase_price_${count_created}">Цена закупа*</label>
                            </div>
                            <div class="input-field col s12">
                                <input class="validate" id="product_purchase_amount_${count_created}" type="number" name="product_purchase_amount[]">
                                <label for="product_purchase_amount_${count_created}">Сумма закупа*</label>
                            </div>
                            <div class="input-field col s12">
                                <select name="product_status_delivery[]">
                                    <? foreach ($status_delivery as $value) : ?>
                                        <option value="<?= $value['status_delivery_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Статус доставка
                                </label>
                            </div>
                            <div class="input-field col s12">
                                <select name="product_status_payment[]">
                                    <? foreach ($status_payment as $value) : ?>
                                        <option value="<?= $value['status_payment_id'] ?>"><?= $value['name'] ?></option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Статус оплаты
                                </label>
                            </div>
                        </div>`;
    </script>
    <? require_once './view/components/script.php'; ?>
</body>

</html>