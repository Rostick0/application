<?

$user_id = (int) $_GET['id'];
$project_id = (int) $_GET['project_id'];

$user = DbQuery::get('user', 'user_id', $user_id)->fetch_assoc();
$project = DbQuery::get('project', 'project_id', $project_id)->fetch_assoc();

$access_list = [
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
    'add_people' => 'Добавлять людей',
    'edit_role' => 'Изменять роли',
    'all' => 'Всё'
];

$access_checked = filter_input(
    INPUT_POST,
    'access_checked',
    FILTER_SANITIZE_STRING,
    FILTER_REQUIRE_ARRAY
);;

if (isset($_REQUEST['button_edit'])) {
    var_dump($access_checked);
    $error = ProjectAccessController::edit($project_id, $access_checked, $user_id);
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Изменение роли</title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <form class="container" method="POST">
                <p class="red-text text-darken-1">
                    <?= $error ?>
                </p>
                <h2>
                    <span>
                        Изменение в проекте #<?= $project['project_id'] ?>
                    </span>
                    &ndash;
                    <span>
                        <?= $project['name'] ?>
                    </span>
                </h2>
                <div class="col s12 m7">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-content__top">
                                <h2 class="card-content__title">
                                    <?= $user['email'] ?>
                                </h2>
                            </div>
                            <div class="input-field col s12">
                                <select multiple name="access_checked[]">
                                    <? foreach ($access_list as $type => $value) : ?>
                                        <option value="<?= $type ?>">
                                            <?= $value ?>
                                        </option>
                                    <? endforeach; ?>
                                </select>
                                <label>
                                    Выбрать доступ
                                </label>
                            </div>
                        </div>
                        <div class="card-action">
                            <button class="waves-effect waves-light btn blue darken-1" name="button_edit">
                                Изменить роль
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>