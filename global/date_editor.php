<?

class DateEditor {
    public static function normalizeDate($date, $haveYear = false) {
        global $MONTHS_SHORT;

        if (mb_strlen($date) < 1) return;

        $result = mb_substr($date, 5, 6);
        $result = $MONTHS_SHORT[mb_substr($result, 0, 2) - 1] . ' ' . mb_substr($result, -2);

        if ($haveYear) {
            $result .= ', ' . mb_substr($date, 0, 4);
        }

        return $result;
    }

    public static function check($date_sql) {
        $result = explode('-', $date_sql);

        return checkdate($result[1], $result[2], $result[0]);
    }

    public static function normalizeDateSql($date) {
        global $MONTHS_SHORT;

        $date = str_replace(',', '', $date);

        $result = explode(' ', $date);

        $year = $result[2];
        $month = (int) array_search($result[0], $MONTHS_SHORT) + 1;
        $day = $result[1];

        $result = "{$year}-{$month}-{$day}";

        if (strlen($result) < 7) return;

        return $result;
    }
}
