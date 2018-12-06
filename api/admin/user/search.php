<?php

include_once __DIR__.DIRECTORY_SEPARATOR . '../../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR . '../../../models/User.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../middleware.php';

/**
 * Tim kiem User
 * 
 * POST
 *  Headers:
 *      + Authorization: token (String)
 *  Body:
 *      + keywords: String
 *      + page: int
 */


$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$queries = Utils::retrieve_queries();

try {
    checkAuthorized();

    $res = $user->search(
        Utils::retrieve_field($queries, 'keywords'),
        Utils::retrieve_field($queries, 'page')
    );

    http_response_code(200);
    echo json_encode($res);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>