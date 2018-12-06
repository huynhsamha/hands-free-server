<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Admin.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/jwt.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../config/app.php';

use \Firebase\JWT\JWT;


$database = new Database();
$db = $database->getConnection();

$user = new Admin($db);

$user->username = Utils::retrieve_post('username');
$user->password = Utils::retrieve_post('password');

try {
    $user->login();

    $key = App::$secret_key;
    $issued_at = time();
    $token_expire = $issued_at + App::$admin_token_expire;
    $token = array(
        'iss' => 'https://hands-free.com',
        'aud' => 'https://hands-free.com',
        'iat' => $issued_at,
        'exp' => $token_expire,
        'data' => array(
            'adminId' => $user->id,
        )
    );

    $token = JWT::encode($token, $key);

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Login successfully. Token chỉ có hiệu lực trong 2 giờ.',
        'user' => $user,
        'token' => $token,
        'issuedAt' => $issued_at,
        'tokenExpire' => $token_expire
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>