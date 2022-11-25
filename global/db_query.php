<?

class DbQuery {
    public static function protectedData($string) {
        if (!$string) return $string;

        $string = trim($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);
        
        return $string;
    }

    public static function replacingQuotes($string) {
        if (!$string) return $string;

        $string = str_replace("'", '&apos;', $string);
        $string = str_replace('"', '&quot;', $string);
        $string = htmlspecialchars($string);

        return $string;
    }

    public static function setIntInArray($array) {
        if (!is_array($array)) return [];

        $result_array = [];

        foreach ($array as $value) {
            $result_array[] = (int) $value;
        }

        return $result_array;
    }

    public static function get($table, $column = null, $value = null, $limit = null, $offset = null) {
        global $db_connect;
    
        if (!$value && !$column) {
            return $db_connect->query("SELECT * FROM `$table`");
        }
    
        $limitAndOffset = null;
    
        if ($limit) {
            $limitAndOffset = "LIMIT $limit";
    
            if ($offset) {
                $limitAndOffset .= " OFFSET $offset";
            }
        }
    
        return $db_connect->query("SELECT * FROM `$table` WHERE `$column` = '$value' $limitAndOffset");
    }

    public static function getCount($table) {
        global $db_connect;

        return $db_connect->query("SELECT COUNT(*) FROM `$table`")->fetch_assoc()["COUNT(*)"];
    }

    public static function parse($table, $column = null, $value = null, $name = 'name') {
        return DbQuery::get($table, $column, $value)->fetch_assoc()[$name];
    }

    public static function getDesc($table, $table_param_id, $limit = 20, $offset = 0) {
        global $db_connect;

        return $db_connect->query("SELECT * FROM `$table` ORDER BY `$table_param_id` DESC LIMIT $limit OFFSET $offset");
    }
}

?>