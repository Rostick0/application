<?

$page = (int) $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page_offset = ($page - 1) * 20;
$page_ceil = ceil($page / 10) * 10 - 9;

$search = $_GET['project_search'];
$status_date = DbQuery::get('status_date');

$project_status_date = $_REQUEST['status_date'] ? $_REQUEST['status_date'] : [];
$project_status_date = is_array($project_status_date) ? $project_status_date : [$project_status_date];

$is_ready = $_REQUEST['is_ready'];

if ($search) {
    $project_count = ProjectController::search($search, $search, $project_status_date, null, null, 'count');
    $page_count = ceil($project_count / 20);

    $project_list = ProjectController::search($search, $search, $project_status_date, $is_ready, 20, $page_offset);
} else {
    $project_count = ProjectController::get($project_status_date, null, null, 'count');
    $page_count = ceil($project_count / 20);

    $project_list = ProjectController::get($project_status_date, $is_ready, 20, $page_offset);
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Все проекты</title>
</head>

<body>
    <div class="wrapper">
        <div class="project">
            <header class="header">
                <? require_once './view/components/header_navigation.php'; ?>
            </header>
            <div class="container">
                <form class="users__form" method="GET">
                    <div class="users__input input-field">
                        <input class="validate" id="project_search" type="text" name="project_search">
                        <label for="project_search">Поиск по названию и id проекта</label>
                    </div>
                    <button class="btn waves-effect waves-light blue darken-1" type="submit">
                        <span>
                            Поиск
                        </span>
                        <i class="material-icons right">send</i>
                    </button>
                    <div class="users__checkboxs">
                        <? foreach ($status_date as $value) : ?>
                            <label>
                                <input name="status_date[]" type="checkbox" class="filled-in" value="<?= $value['status_date_id'] ?>" <?= array_search($value['status_date_id'], $project_status_date) !== false ? 'checked' : '' ?> />
                                <span>
                                    <?= $value['name'] ?>
                                </span>
                            </label>
                        <? endforeach ?>
                    </div>
                    <div class="switch">
                        <label>
                            <input type="checkbox" name="is_ready" <?= $is_ready ? 'checked' : '' ?>>
                            <span class="lever"></span>
                            <span>
                                Только готовые
                            </span>
                        </label>
                    </div>
                </form>
                <? foreach ($project_list as $project) : ?>
                    <div class="col s12 m7">
                        <div class="card <?= ProjectController::colorProject($project['status_date'], $project['is_ready']) ?>">
                            <div class="card-content">
                                <div class="card-content__top">
                                    <h2 class="card-content__title">
                                        <?= $project['name'] ?>
                                    </h2>
                                    <div class="card-contet__time">
                                        <?= $project['start_date'] ?>
                                    </div>
                                </div>
                                <p>
                                    <?= $project['address'] ?>
                                </p>
                                <p class="card-content__ready-status">
                                    <strong>
                                        <? if ($project['is_ready']) : ?>
                                            <span>
                                                Готов
                                            </span>
                                        <? else : ?>
                                            <span>
                                                Не готов
                                            </span>
                                        <? endif; ?>
                                    </strong>
                                </p>
                            </div>
                            <div class="card-action">
                                <a href="/project?id=<?= $project['project_id'] ?>">Подробнее</a>
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
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>