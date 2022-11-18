<?

class Authorization {
    public static function create($token, $info, $ip, $user_id) {
        global $db_connect;

        return $db_connect->query("INSERT INTO `authorization` (`token`, `info`, `ip`, `user_id`) VALUES ('$token', '$info', '$ip', '$user_id')");
    }

    public static function getLastToken($token) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `authorization` WHERE `token` = '$token' ORDER BY `authorization_id` DESC LIMIT 1");
    }
}

?>