<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/jwt.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/app.php';

use \Firebase\JWT\JWT;


$token = Utils::retrieve_token();

try {
    if (!$token) {
        throw new Exception('Unauthorized. Token is required.');
    }

    $key = App::$secret_key;
    $decoded = JWT::decode($token, $key, array('HS256'));

    http_response_code(200);
    echo json_encode(array(
        'data' => $decoded->data
    ));

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode($e->getMessage());
}

?>