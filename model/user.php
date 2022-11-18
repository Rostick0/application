<?

class User {
    public static function create($name, $email, $password, $about = null) {
        global $db_connect;

        $about = !empty($about) ? "'$about'" : "NULL";

        $query = $db_connect->query("INSERT INTO `user` (`name`, `email`, `password`, `about`) VALUES ('$name', '$email', '$password', $about)");

        if ($query) {
            return mysqli_insert_id($db_connect);
        }
    }
}

?>