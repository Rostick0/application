<?

$page = $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page_offset = ($page - 1) * 10;
$page_ceil = ceil($page / 10) * 10 - 9;

$search = $_GET['project_history_search'];
$status_date = DbQuery::get('status_date');

$history_status_date = $_REQUEST['status_date'] ? $_REQUEST['status_date'] : [];
$history_status_date = is_array($history_status_date) ? $history_status_date : [$history_status_date];

$is_ready = $_REQUEST['is_ready'];

if ($search) {
    $project_count = ProjectHistoryEditController::search($search, $search, $history_status_date, $is_ready, null, null, 'count');
    $page_count = ceil($project_count / 10);

    $project_list = ProjectHistoryEditController::search($search, $search, $history_status_date, $is_ready, 10, $page_offset);
    
} else {
    $project_count = ProjectHistoryEditController::get($history_status_date, $is_ready, null, null, 'count');
    $page_count = ceil($project_count / 10);
    
    $project_list = ProjectHistoryEditController::get($history_status_date, $is_ready, 10, $page_offset);
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
                <form class="users__form" method="GET">
                    <div class="users__input input-field">
                        <input class="validate" id="project_history_search" type="text" name="project_history_search">
                        <label for="project_history_search">Поиск по названию и id проекта</label>
                    </div>
                    <button class="btn waves-effect waves-light blue darken-1" type="submit">
                        <span>
                            Поиск
                        </span>
                        <i class="material-icons right">send</i>
                    </button>
                    <div class="users__checkboxs">
                        <? foreach ($status_date as $value): ?>
                            <label>
                                <input name="status_date[]" type="checkbox" class="filled-in" value="<?= $value['status_date_id'] ?>" <?= array_search($value['status_date_id'], $history_status_date) !== false ? 'checked' : '' ?> />
                                <span>
                                    <?= $value['name'] ?>
                                </span>
                            </label>
                        <? endforeach ?>
                    </div>
                    <div class="users__checkboxs">
                        <label>
                            <input class="filled-in" type="checkbox" name="is_ready" <?= $is_ready ? 'checked' : '' ?>>
                            <span>
                                Только готовые
                            </span>
                        </label>
                    </div>
                </form>
                <? foreach ($project_list as $project) : ?>
                    <div class="col s12 m7">
                        <div class="card <?= ProjectController::colorProject(DbQuery::parse('project', 'project_id', $project['project_id'], 'status_date'), DbQuery::parse('project', 'project_id', $project['project_id'], 'is_ready')) ?>">
                            <div class="card-content">
                                <p>
                                    <strong>
                                        <a class="card__link" href="/project?id=<?= $project['project_id'] ?>">
                                            Проект #<?= $project['project_id'] ?>
                                        </a>
                                    </strong>
                                </p>
                                <? 
                                    $project_name = DbQuery::parse('project', 'project_id', $project['project_id'], 'name');

                                    if ($project_name):
                                ?>
                                    <p>
                                        <?= $project_name ?>
                                    </p>
                                <? endif ?>
                                <p>
                                    <?= $project['created_date'] ?>
                                </p>
                                <p>
                                <p>
                                    <strong>
                                        <?= DbQuery::parse('user', 'user_id', $project['user_id'], 'FCs') . " " . DbQuery::parse('user', 'user_id', $project['user_id'], 'post') ?>
                                    </strong>
                                </p>
                                <p>
                                    <q>
                                        <?= $project['name'] ?>
                                    </q>
                                    <? if ($project['old'] && $project['new']) : ?>
                                        <span>
                                            <span>
                                                старое значение
                                            </span>
                                            <q>
                                                <?= $project['old'] ?>
                                            </q>
                                        </span>
                                        <span>
                                            <span>
                                                Новое значение
                                            </span>
                                            <q>
                                                <?= $project['new'] ?>
                                            </q>
                                        </span>
                                    <? endif ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <?
                $page;
                $page_ceil;

                $project_count;
                $page_count;

                if ($search) $project_query_add = "&project_history_search=$search";
                if ($history_status_date) $project_query_add .= '&status_date%5B%5D=' . implode('&status_date%5B%5D=', $history_status_date);

                require_once './view/components/pagination.php';
                ?>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>