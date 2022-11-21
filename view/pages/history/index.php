<?

$page = $_GET['page'];
$page = $page ? $page : 1;
$page = $_GET['page'] < 1 ? $_GET['page'] = 1 : $_GET['page'];

$page;
$page_offset = ($page - 1) * 20;
$page_ceil = ceil($page / 10) * 10 - 9;

$project_count = DbQuery::get('project')->num_rows;
$page_count = ceil($project_count / 20);

$project_list = DbQuery::getDesc('project_history_edit', 'project_history_edit_id', 20, $page_offset);

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
                    <div class="col s12 m7">
                        <div class="card">
                            <div class="card-content">
                                <p>
                                    <strong>
                                        Проект #<?= $project['project_id'] ?>
                                    </strong>
                                </p>
                                <p>
                                    <?= $project['created_date'] ?>
                                </p>
                                <p>
                                <p>
                                    <strong>
                                        Пользователь <?= DbQuery::parse('user', 'user_id', $project['user_id'], 'email') ?>
                                    </strong>
                                </p>
                                <? foreach (json_decode($project['action'], true) as $value) : ?>
                                    <p>
                                        <span>
                                            в поле
                                        </span>
                                        <q>
                                            <?= $value['name'] ?>
                                        </q>
                                        <span>
                                            с
                                        </span>
                                        <q>
                                            <?= $value['old'] ?>
                                        </q>
                                        <span>
                                            на
                                        </span>
                                        <q>
                                            <?= $value['new'] ?>
                                        </q>
                                    </p>
                                <? endforeach; ?>
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
                require_once './view/components/pagination.php';
                ?>
            </div>
        </div>
    </div>
    <? require_once './view/components/script.php'; ?>
</body>

</html>