<?

$URI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$MONTHS_SHORT = [
    'Янв',
    'Фев',
    'Мар',
    'Апр',
    'Май',
    'Июн',
    'Июл',
    'Авг',
    'Сен',
    'Окт',
    'Ноя',
    'Дек'
];

$PATH_UPLOAD = "./view/static/upload/";

$ALLOWED_DOCUMENT_TYPES = [
    'image/png',
    'image/jpeg',
    'image/jpg'
];

?>