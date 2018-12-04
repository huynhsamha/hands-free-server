<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->firstName = Utils::retrieve_post('firstName');
$user->lastName = Utils::retrieve_post('lastName');
$user->tel = Utils::retrieve_post('tel');
$user->address = Utils::retrieve_post('address');

try {
    $data = checkAuthorized();
    $user->id = $data->userId;

    $user->updateInfo();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Update successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>