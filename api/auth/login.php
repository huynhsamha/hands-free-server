<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = Utils::retrieve_post('email');
$user->password = Utils::retrieve_post('password');

try {
    $data = $user->login();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Login successfully',
        'user' => $user,
        // 'token' => $data['token'],
        // 'token_expire' => $data['token_expire']
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>