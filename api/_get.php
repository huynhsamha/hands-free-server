<?php

header('Content-type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: OPTIONS, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Authorization");

if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    exit(0);
}

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    header("HTTP/1.0 403 Forbidden");
    print("Forbidden");
    exit();
}

include_once __DIR__.DIRECTORY_SEPARATOR.'../config/database.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/Utils.php';

?>