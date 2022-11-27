<?

function checkEdited($old, $new) {
    if (is_null($old) && is_null($new)) return false;

    return $old == $new;
}

?>