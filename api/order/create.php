<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderInfo.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderDetail.php';


$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

$order->paymenAddress = Utils::retrieve_post('paymenAddress');
$order->paymentMethod = Utils::retrieve_post('paymentMethod');
// $products = Utils::retrieve_post('products');

try {
    // $model->create();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully',
        'orderInfo' => $order
        // 'products' => $products
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>