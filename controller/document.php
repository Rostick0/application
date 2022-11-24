<?

class DocumentController {
    public static function upload($image) {
        global $PATH_UPLOAD;

        if (!$image['name']) return;

        $name = DocumentController::setName($image['type']);
        $path = $PATH_UPLOAD . $name;

        $upload = move_uploaded_file($image['tmp_name'], $path);
        
        if (!$upload) return NULL;

        return $name;
    }

    public static function setName($type) {
        return time() . random_int(1000, 9999) . "." . DocumentController::getType($type);
    }

    public static function getType($type) {
        return array_pop(explode('/', $type));
    }

    public static function delete($name) {
        global $PATH_UPLOAD;

        if (!$name) return;

        $path = $PATH_UPLOAD . $name;

        if (!file_exists($path)) return;

        return unlink($path);
    }

    public static function update($document_new, $document_old) {
        DocumentController::delete($document_old);
        return DocumentController::upload($document_new);
    }

    public static function checkType($type) {
        global $ALLOWED_DOCUMENT_TYPES;

        return array_search($type, $ALLOWED_DOCUMENT_TYPES);
    }
}

?>