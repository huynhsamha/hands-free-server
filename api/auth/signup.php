<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->email = Utils::retrieve_post('email');
$user->first_name = Utils::retrieve_post('first_name');
$user->last_name = Utils::retrieve_post('last_name');
$user->tel = Utils::retrieve_post('tel');
$user->photo_url = Utils::retrieve_post('photo_url');
$user->address = Utils::retrieve_post('address');
$user->password = Utils::retrieve_post('password');

try {
    $user->create();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Sign up successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>