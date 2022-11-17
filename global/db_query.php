<?

class DbQuery {
    public static function protectedData($string) {
        $string = trim($string);
        $string = htmlspecialchars($string);
        $string = addslashes($string);
        
        return $string;
    }

    public static function get($table, $column = null, $value = null, $limit = null, $offset = null) {
        global $db;
    
        if (!$value && !$column) {
            return $db->query("SELECT * FROM `$table`");
        }
    
        $limitAndOffset = null;
    
        if ($limit) {
            $limitAndOffset = "LIMIT $limit";
    
            if ($offset) {
                $limitAndOffset .= " OFFSET $offset";
            }
        }
    
        return $db->query("SELECT * FROM `$table` WHERE `$column` = '$value' $limitAndOffset");
    }

    public static function parse($table, $column = null, $value = null, $name = 'name') {
        return DbQuery::get($table, $column, $value)->fetch_assoc()[$name];
    }
}

?>