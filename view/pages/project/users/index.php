<?

$page = $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page_offset = ($page - 1) * 20;
$page_ceil = ceil($page / 10) * 10 - 9;

$project_count = DbQuery::get('project')->num_rows;
$page_count = ceil($project_count / 20);

$user_list = DbQuery::getDesc('user', 'user_id', 20, $page_offset);

$project_access_list = [
    'name' => 'Название',
    'address' => 'Адрес',
    'start_date' => 'Дата начала',
    'end_date' => 'Дата окончания',
    'count' => 'Количество',
    'count_defective' => 'Количество брака',
    'price' => 'Цена',
    'price_commission' => 'Цена с комиссией',
    'comment' => 'Комменатрий',
    'complaint' => 'Замечания',
    'all' => 'Всё'
];


if (isset($_REQUEST['button_edit'])) {
    var_dump($_REQUEST['user_access_2']);
}

// var_dump($button_edit);

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
            <form class="container" method="POST">
                <? foreach ($user_list as $user) : ?>
                    <div class="col s12 m7">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-content__top">
                                    <h2 class="card-content__title">
                                        <?= $user['email'] ?>
                                    </h2>
                                </div>
                            </div>
                            <div class="card-action">
                                <a href="/project/users/add?id=<?= $user['user_id'] ?>">
                                    Изменить роль
                                </a>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <?
                $page;
                $page_ceil;

                $project_count;
                $page_count;
                require_once './view/components/pagination.php';
                ?>
            </form>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>