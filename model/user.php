<?

class User {
    public static function create($email, $password, $FCs, $post, $telephone, $about = null) {
        global $db_connect;

        $FCs = !empty($FCs) ? "'$FCs'" : "NULL";
        $telephone = !empty($telephone) ? "'$telephone'" : "NULL";
        $about = !empty($about) ? "'$about'" : "NULL";

        $query = $db_connect->query("INSERT INTO `user` (`email`, `password`, `FCs`, `post`,  `telephone`, `about`) VALUES ('$email', '$password', $FCs, '$post', $telephone, $about)");

        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }

    public static function search($FCs, $limit = 20, $offset = 0) {
        global $db_connect;

        $FCs = !empty($FCs) ? "'%$FCs%'" : "NULL";

        return $db_connect->query("SELECT * FROM `user` WHERE `FCs` LIKE $FCs ORDER BY `user_id` DESC LIMIT $limit OFFSET $offset");
    }
}

?>