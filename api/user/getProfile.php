<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

try {
    $data = checkAuthorized();
    $user->id = $data->userId;

    $user->getProfile();

    http_response_code(200);
    echo json_encode($user);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>