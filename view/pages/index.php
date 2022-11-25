<?

$page = (int) $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page_offset = ($page - 1) * 20;
$page_ceil = ceil($page / 10) * 10 - 9;

$project_count = DbQuery::getCount('project');
$page_count = ceil($project_count / 20);

$project_list = DbQuery::getDesc('project', 'project_id', 20, $page_offset);

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