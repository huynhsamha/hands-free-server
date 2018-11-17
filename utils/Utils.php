<?php

class Utils {

    public static function retrieve_post($fieldName) {
        return isset($_POST[$fieldName]) ? htmlspecialchars(strip_tags($_POST[$fieldName])) : null;
    }

    public static function retrieve_get($fieldName) {
        return isset($_GET[$fieldName]) ? htmlspecialchars(strip_tags($_GET[$fieldName])) : null;
    }

    public static function retrieve_header($fieldName) {
        $headers = apache_request_headers();
        return isset($headers[$fieldName]) ? $headers[$fieldName] : null;
    }

    public static function retrieve_token() {
        return Utils::retrieve_header('Authorization');
    }

}

?>