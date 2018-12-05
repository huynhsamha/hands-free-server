<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderInfo.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/OrderDetail.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Product.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

$order->paymentAddress = Utils::retrieve_post('paymentAddress');
$order->paymentMethod = Utils::retrieve_post('paymentMethod');
$products = Utils::retrieve_post('products');

function handleError($err, OrderInfo $order) {
    try {
        $order->deleteByID();
    } catch (Error $e) {

    } finally {
        http_response_code(400);
        echo json_encode($err->getMessage());
    }
}

try {
    $data = checkAuthorized();
    $order->userId = $data->userId;

    $order->create();

    $orderDetailList = array();
    $productList = array();

    $order->totalPrice = 0;
    
    // Validate order
    foreach ($products as $item) {
        $product = new Product($db);
        $product->id = intval($item['productId']);
        $product->findByID();

        $orderDetail = new OrderDetail($db);
        $orderDetail->orderId = $order->id;
        $orderDetail->productId = $product->id;
        $orderDetail->unitPrice = $product->price;
        $orderDetail->quantity = intval($item['quantity']);

        $product->quantity -= $orderDetail->quantity;

        if ($product->quantity < 0) {
            throw new Error("Sản phẩm <i>$product->name</i> không đủ $orderDetail->quantity cái. Hiện tại shop còn thiếu ".(-$product->quantity)." cái.");
        }

        array_push($orderDetailList, $orderDetail);
        array_push($productList, $product);
    }

    // Create order detail
    foreach ($orderDetailList as $orderDetail) {
        $orderDetail->create();
        $order->totalPrice += $orderDetail->totalPrice;
    }

    // Update product quantity
    foreach ($productList as $product) {
        $product->updateQuantity();
    }

    $order->updateTotalPrice();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully',
        'order' => $order
    ));

} catch (Error $err) {
    handleError($err, $order);

} catch (Exception $err) {
    handleError($err, $order);
}

?>