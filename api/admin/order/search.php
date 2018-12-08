<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../../models/OrderInfo.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../middleware.php';

/**
 * Tim kiem Order
 * 
 * POST
 *  Headers:
 *      + Authorization: token (String)
 *  Body: 
 *      maybe null, default: page 1, 20 phần tử / page
 *      + keywords: String
 *      + page: int
 * 
 * Example Response:
 * 
 * {
 *   "total": "6",
 *   "page": 1,
 *   "onePage": 20,
 *   "totalPage": 1,
 *   "offset": 0,
 *   "data": [
 *       {
 *           "id": "100000",
 *           "userId": "5025",
 *           "orderTime": "2018-12-05 19:43:50",
 *           "approveTime": null,
 *           "completeTime": null,
 *           "status": "Completed",
 *           "paymentAddress": "shop_hcm",
 *           "paymentMethod": "cash",
 *           "totalPrice": "2290000"
 *       },
 *      ...
 *  ]
 * }
 */


$database = new Database();
$db = $database->getConnection();

$order = new OrderInfo($db);

$queries = Utils::retrieve_queries();

try {
    checkAuthorized();

    $res = $order->search(
        Utils::retrieve_field($queries, 'keywords'),
        Utils::retrieve_field($queries, 'page')
    );

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