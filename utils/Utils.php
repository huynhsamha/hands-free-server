<?php

class Utils {

    public static function retrieve_post($fieldName) {
        if (isset($_POST[$fieldName])) {
            $p = strip_tags($_POST[$fieldName]);
            return strlen($p) > 0 ? $p : null;
        }
        return null;
    }

    public static function retrieve_get($fieldName) {
        if (isset($_GET[$fieldName])) {
            $p = strip_tags($_GET[$fieldName]);
            return strlen($p) > 0 ? $p : null;
        }
        return null;
    }

    public static function retrieve_header($fieldName) {
        $headers = apache_request_headers();
        if (isset($headers[$fieldName])) {
            $p = strip_tags($headers[$fieldName]);
            return strlen($p) > 0 ? $p : null;
        }
        return null;
    }

    public static function retrieve_token() {
        return Utils::retrieve_header('Authorization');
    }

}

?>