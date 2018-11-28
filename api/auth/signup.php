<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = Utils::retrieve_post('email');
$user->firstName = Utils::retrieve_post('firstName');
$user->lastName = Utils::retrieve_post('lastName');
$user->tel = Utils::retrieve_post('tel');
$user->photoUrl = Utils::retrieve_post('photoUrl');
$user->address = Utils::retrieve_post('address');
$user->password = Utils::retrieve_post('password');

try {
    $user->create();

    http_response_code(201);
    echo json_encode(array(
        // 'message' => 'Sign up successfully'
        'message' => 'Đăng kí tài khoản thành công.'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>