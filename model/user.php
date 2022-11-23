<?

class User {
    public static function create($name, $email, $password, $FCs, $telephone, $about = null) {
        global $db_connect;

        $FCs = !empty($FCs) ? "'$FCs'" : "NULL";
        $telephone = !empty($telephone) ? "'$telephone'" : "NULL";
        $about = !empty($about) ? "'$about'" : "NULL";

        $query = $db_connect->query("INSERT INTO `user` (`name`, `email`, `password`, `FCs`, `telephone` `about`) VALUES ('$name', '$email', '$password', '$FCs', '$telephone', $about)");

        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }

    public static function search($email, $limit = 20, $offset = 0) {
        global $db_connect;

        $email = !empty($email) ? "'%$email%'" : "NULL";

        return $db_connect->query("SELECT * FROM `user` WHERE `email` LIKE $email ORDER BY `user_id` DESC LIMIT $limit OFFSET $offset");
    }
}

?>