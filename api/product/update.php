<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . '../_post.php';

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../models/Product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);
$newProduct = new Product($db);

$product->id = Utils::retrieve_post('id');

$newProduct->id = Utils::retrieve_post('id');
$newProduct->name = Utils::retrieve_post('name');
$newProduct->thumbnail = Utils::retrieve_post('thumbnail');
$newProduct->price = Utils::retrieve_post('price');
// $newProduct->priceText = Utils::retrieve_post('priceText');
$newProduct->ceilPrice = Utils::retrieve_post('ceilPrice');
// $newProduct->ceilPriceText = Utils::retrieve_post('ceilPriceText');
$newProduct->bestSell = Utils::retrieve_post('bestSell');
$newProduct->bestGift = Utils::retrieve_post('bestGift');
$newProduct->bestPrice = Utils::retrieve_post('bestPrice');
$newProduct->hotNew = Utils::retrieve_post('hotNew');
$newProduct->quantity = Utils::retrieve_post('quantity');
$newProduct->status = Utils::retrieve_post('status');
$newProduct->warranty = Utils::retrieve_post('warranty');
$newProduct->technicalInfo = Utils::retrieve_post('technicalInfo');
$newProduct->galleryImages = Utils::retrieve_post('galleryImages');

$boolFields = ['bestSell' ,'bestGift', 'bestPrice', 'hotNew'];
foreach ($boolFields as $field) {
    if ($newProduct->$field) {
        $newProduct->$field = $newProduct->$field == "true";
    }
}

try {
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