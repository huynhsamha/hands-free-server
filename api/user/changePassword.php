<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$oldPassword = Utils::retrieve_post('oldPassword');
$newPassword = Utils::retrieve_post('newPassword');

try {
    $data = checkAuthorized();
    $user->id = $data->userId;

    $user->changePassword($oldPassword, $newPassword);

    http_response_code(200);
    echo json_encode(array(
        'message' => 'Change password successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>