<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/jwt.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/app.php';

use \Firebase\JWT\JWT;


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = Utils::retrieve_post('email');
$user->password = Utils::retrieve_post('password');

try {
    $user->email = strtolower($user->email);
    $user->login();

    $key = App::$secret_key;
    $issued_at = time();
    $token_expire = $issued_at + App::$token_expire;
    $token = array(
        'iss' => 'https://hands-free.com',
        'aud' => 'https://hands-free.com',
        'iat' => $issued_at,
        'exp' => $token_expire,
        'data' => array(
            'userId' => $user->id,
        )
    );

    $token = JWT::encode($token, $key);

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Login successfully',
        'user' => $user,
        'token' => $token,
        'issuedAt' => $issued_at,
        'tokenExpire' => $token_expire
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>