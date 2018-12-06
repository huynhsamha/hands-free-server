<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Admin.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'./middleware.php';


$database = new Database();
$db = $database->getConnection();

$user = new Admin($db);

$user->username = Utils::retrieve_post('username');
$user->password = Utils::retrieve_post('password');

try {
    checkAuthorized();

    $user->create();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Admin mới đã được tạo thành công.'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>