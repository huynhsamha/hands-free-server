<?php

include_once __DIR__ . DIRECTORY_SEPARATOR . '../_post.php';

include_once __DIR__ . DIRECTORY_SEPARATOR . '../../models/Product.php';
include_once __DIR__ . DIRECTORY_SEPARATOR . '../../models/Model.php';

$database = new Database();
$db = $database->getConnection();

$model = new Model($db);
$product = new Product($db);

$model->name = Utils::retrieve_post('modelName');
$product->name = Utils::retrieve_post('name');
$product->thumbnail = Utils::retrieve_post('thumbnail');
$product->price = Utils::retrieve_post('price');
$product->priceText = Utils::retrieve_post('priceText');
$product->ceilPrice = Utils::retrieve_post('ceilPrice');
$product->ceilPriceText = Utils::retrieve_post('ceilPriceText');
$product->bestSell = Utils::retrieve_post('bestSell') == "true";
$product->bestGift = Utils::retrieve_post('bestGift') == "true";
$product->bestPrice = Utils::retrieve_post('bestPrice') == "true";
$product->hotNew = Utils::retrieve_post('hotNew') == "true";
$product->quantity = Utils::retrieve_post('quantity');
$product->status = Utils::retrieve_post('status');
$product->warranty = Utils::retrieve_post('warranty');
$product->technicalInfo = Utils::retrieve_post('technicalInfo');
$product->galleryImages = Utils::retrieve_post('galleryImages');

try {
    $model->findOneByName();

    $product->modelId = $model->id;

    $product->create();

    $model->addOneProduct();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully',
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>