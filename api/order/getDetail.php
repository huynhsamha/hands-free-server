<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderInfo.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderDetail.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);
$orderDetail = new OrderDetail($db);
$order->id = Utils::retrieve_get('orderId');
$orderDetail->orderId = $order->id;

try {
    $data = checkAuthorized();
    $userId = $data->userId;

    $order->checkIsOwner($userId);

    $res = $orderDetail->findAllInOrder();

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