<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderInfo.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

try {
    $data = checkAuthorized();
    $order->userId = $data->userId;

    $res = $order->findAllByUser();

    http_response_code(200);
    echo json_encode($res);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>