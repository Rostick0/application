<?

$project_id = (int) $_GET['id'];

$project = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();
$products = DbQuery::get('product', 'project_id', $project_id);

if (!$project) {
    header('Location: /project/create');
}

$contract_amount = 0;

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Проекта <?= $project['name'] ?></title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <div class="container">
                <div class="project__container">
                    <form class="col s12 project__form" method="POST">
                        <div class="project__flex">
                            <strong>
                                Заказ сделан?
                            </strong>
                            <p>
                                <?= $project['is_made_order'] ? 'Да' : 'Нет' ?>
                            </p>
                        </div>
                        <div class="project__flex">
                            <strong>
                                Документы готовы?
                            </strong>
                            <p>
                                <?= $project['documents'] ? 'Да' : 'Нет' ?>
                            </p>
                        </div>
                        <div class="project__flex">
                            <strong>
                                Скан документов готов?
                            </strong>
                            <p>
                                <?= $project['document_scan'] ? 'Да' : 'Нет' ?>
                            </p>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <strong>
                                    Название
                                </strong>
                                <p>
                                    <?= $project['name'] ?>
                                </p>
                            </div>
                            <div class="input-field col s12">
                                <strong>
                                    ИНН
                                </strong>
                                <p>
                                    <?= $project['inn'] ?>
                                </p>
                            </div>
                            <div class="input-field col s12">
                                <strong>
                                    Номер договора
                                </strong>
                                <p>
                                    <?= HtmlDom::checkData($project['contract']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <strong>
                                    ЗМО
                                </strong>
                                <p>
                                    <?= DbQuery::parse('zmo', 'zmo_id', $project['zmo_id']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="project__flex">
                            <div class="input-field col s12">
                                <strong>
                                    Дата начала
                                </strong>
                                <p>
                                    <?= HtmlDom::checkData(DateEditor::normalizeDate($project['start_date'], true)) ?>
                                </p>
                            </div>
                            <div class="input-field col s12">
                                <strong>
                                    Дата окончания
                                </strong>
                                <p>
                                    <?= HtmlDom::checkData(DateEditor::normalizeDate($project['end_date'], true)) ?>
                                </p>
                            </div>
                            <div class="input-field col s12">
                                <strong>
                                    Дата доставки
                                </strong>
                                <p>
                                    <?= DateEditor::normalizeDate($project['delivery_date'], true) ?>
                                </p>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <div class="input-field col s12">
                                <strong>
                                    Сумма контракта
                                </strong>
                                <p class="product__amount_price">

                                </p>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <div class="input-field col s12">
                                <strong>
                                    Комментарий
                                </strong>
                                <p>
                                    <?= HtmlDom::checkData($project['comment']) ?>
                                </p>
                            </div>
                        </div>
                        <div class="input-field col s12">
                            <div class="input-field col s12">
                                <strong>
                                    Замечания
                                </strong>
                                <p>
                                    <?= HtmlDom::checkData($project['complaint']) ?>
                                </p>
                            </div>
                        </div>
                        <? foreach ($products as $product) : ?>
                            <? $contract_amount += $product['amount'] + $product['shipping_cost'] ?>
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
                                        Трек номер
                                    </strong>
                                    <p>
                                        <?= HtmlDom::checkData($product['track_number']) ?>
                                    </p>
                                </div>
                                <div class="input-field col s12">
                                    <strong>
                                        Склад
                                    </strong>
                                    <p>
                                        <?= HtmlDom::checkData($product['warehouse']) ?>
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
                        <div class="project__button">
                            <div class="project__button_inner">
                                <a class="waves-effect waves-light btn-large blue darken-1" href="project/edit?id=<?= $project_id ?>">
                                    Изменить
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
    <script defer>
        const productAmountPrice = document.querySelector('.product__amount_price');

        productAmountPrice.textContent = "<?= $contract_amount ? $contract_amount : '-' ?>";
    </script>
</body>

</html>