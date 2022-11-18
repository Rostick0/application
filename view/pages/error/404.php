<?

http_response_code(404);

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? require_once './view/components/style.php'; ?>
    <title>Ошибка 404</title>
</head>

<body>
    <div class="wrapper">
        <div class="page-404 center-align">
            <div class="page-404__text red-text text-darken-1">
                <strong>
                    <h2 class="page-404__title">
                        404
                    </h2>     
                    <div class="page-404__description">
                        Ошибка, страница не найдена
                    </div>
                </strong>
            </div>
            <a href="/">
                Перейти на главную
            </a>
        </div>
    </div>
</body>

</html>