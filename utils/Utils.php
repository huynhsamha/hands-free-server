<?php

class Utils {

    public static function retrieve_field($array, $fieldName) {
        if (isset($array[$fieldName])) {
            $p = $array[$fieldName];
            if (is_array($p)) return $p;
            $p = strip_tags($p);
            return strlen($p) > 0 ? $p : null;
        }
        return null;
    }

    public static function retrieve_post($fieldName) {
        return Utils::retrieve_field($_POST, $fieldName);
    }

    public static function retrieve_get($fieldName) {
        return Utils::retrieve_field($_GET, $fieldName);
    }

    public static function retrieve_header($fieldName) {
        $headers = apache_request_headers();
        return Utils::retrieve_field($headers, $fieldName);
    }

    public static function retrieve_token() {
        return Utils::retrieve_header('Authorization');
    }

    public static function retrieve_queries() {
        $queries = array();
        parse_str($_SERVER['QUERY_STRING'], $queries);
        return $queries;
    }

    public static function defaultNull($x, $default) {
        return $x !== null ? $x : $default;
    }
}

?>