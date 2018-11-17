<?php

class Utils {

    public static function retrieve_post($fieldName) {
        return isset($_POST[$fieldName]) ? htmlspecialchars(strip_tags($_POST[$fieldName])) : null;
    }

    public static function retrieve_get($fieldName) {
        return isset($_GET[$fieldName]) ? htmlspecialchars(strip_tags($_GET[$fieldName])) : null;
    }

}

?>