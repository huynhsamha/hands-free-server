<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../_post.php';

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../../models/Product.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../middleware.php';

/**
 * Cap nhat 1 product
 * 
 * POST
 *  Headers:
 *      + Authorization: token (String)
 *  Body:
 *      + id: int
 *      + name: (String)
 *      + price: int
 *      + ceilPrice: int
 *      + status: String
 *      + warranty: String
 *      + bestSell, bestGift, bestPrice, hotNew, hotDeal, recentlyViewed: boolean
 */


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$newProduct = new Product($db);

$product->id = Utils::retrieve_post('id');

$newProduct->id = Utils::retrieve_post('id');
$newProduct->name = Utils::retrieve_post('name');
// $newProduct->thumbnail = Utils::retrieve_post('thumbnail');
$newProduct->price = Utils::retrieve_post('price');
$newProduct->ceilPrice = Utils::retrieve_post('ceilPrice');

$newProduct->bestSell = Utils::retrieve_post('bestSell') == "true";
$newProduct->bestGift = Utils::retrieve_post('bestGift') == "true";
$newProduct->bestPrice = Utils::retrieve_post('bestPrice') == "true";
$newProduct->hotNew = Utils::retrieve_post('hotNew') == "true";
$newProduct->hotDeal = Utils::retrieve_post('hotDeal') == "true";
$newProduct->recentlyViewed = Utils::retrieve_post('recentlyViewed') == "true";

// $newProduct->quantity = Utils::retrieve_post('quantity');
$newProduct->status = Utils::retrieve_post('status');
$newProduct->warranty = Utils::retrieve_post('warranty');
// $newProduct->technicalInfo = Utils::retrieve_post('technicalInfo');
// $newProduct->galleryImages = Utils::retrieve_post('galleryImages');


try {
    checkAuthorized();

    $product->findByID();
    
    $product->mergeNew($newProduct);

    $product->update();

    http_response_code(200);
    echo json_encode(array(
        'message' => 'Update successfully',
        'product' => $product
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>