<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../../models/OrderInfo.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../middleware.php';

/**
 * Complete 1 output_add_rewrite_var
 * 
 * POST
 *  Headers:
 *      + Authorization: token (String)
 *  Body:
 *      + orderId: (int)
 */

$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

$order->id = Utils::retrieve_post('orderId');

try {
    checkAuthorized();

    $order->findByID();

    if ($order->status == 'Order') {
        throw new Error('Yêu cầu lỗi. Đơn hàng này chưa được xử lý và chấp nhận.');
    }
    if ($order->status == 'Completed') {
        throw new Error('Yêu cầu lỗi. Đơn hàng này đã được hoàn tất.');
    }

    $order->completeStatus();

    http_response_code(200);
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