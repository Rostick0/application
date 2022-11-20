<?

$page = $_GET['page'] < 1 ? $_GET['page'] = 0 : $_GET['page'];

$project_list = ProjectController::getMy();

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
                <? foreach ($project_list as $project) : ?>
                    <div class="row">
                        <div class="col s12 m7">
                            <div class="card">
                                <div class="card-content">
                                    <h2>
                                        <?= $project['name'] ?>
                                    </h2>
                                    <p>
                                        <?= $project['address'] ?>
                                    </p>
                                </div>
                                <div class="card-action">
                                    <a href="/project?id=<?= $project['project_id'] ?>">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <? endforeach; ?>
                <?
                    $page;
                    $page_ceil = ceil($page / 10) * 10 - 9;

                    $project_count = DbQuery::get('project')->num_rows;
                    $page_count = ceil($project_count / 20);
                    require_once './view/components/pagination.php';
                ?>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>