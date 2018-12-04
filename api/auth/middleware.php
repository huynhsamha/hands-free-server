<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/jwt.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/app.php';

use \Firebase\JWT\JWT;

function checkAuthorized() {

    $token = Utils::retrieve_token();

    if (!$token) {
        throw new Error('Unauthorized. Token is required.');
    }

    $key = App::$secret_key;
    $decoded = JWT::decode($token, $key, array('HS256'));

    return $decoded->data;
}

?>