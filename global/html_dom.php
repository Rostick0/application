<?

class HtmlDom {
    public static function setClass($class, $if = null) {
        if (!$if) return;
    
        return $class;
    }

    public static function checkData($data, $substitution = '-') {
        if ($data) return $data;

        return $substitution;
    }
}

?>