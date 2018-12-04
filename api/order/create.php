<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderInfo.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderDetail.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

$order->paymentAddress = Utils::retrieve_post('paymentAddress');
$order->paymentMethod = Utils::retrieve_post('paymentMethod');
$products = Utils::retrieve_post('products');

try {
    $data = checkAuthorized();
    $order->userId = $data->userId;

    $order->create();

    $orderDetail = new OrderDetail($db);
    $orderDetail->orderId = $order->id;

    $order->totalPrice = 0;

    foreach ($products as $item) {
        $orderDetail->productId = intval($item['productId']);
        $orderDetail->quantity = intval($item['quantity']);
        $orderDetail->unitPrice = intval($item['unitPrice']);

        $orderDetail->create();

        $order->totalPrice += $orderDetail->totalPrice;
    }

    $order->updateTotalPrice();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully',
        'order' => $order
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>