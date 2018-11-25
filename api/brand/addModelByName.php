<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Model.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Brand.php';


$database = new Database();
$db = $database->getConnection();

$brand = new Brand($db);
$model = new Model($db);

$brand->name = Utils::retrieve_post('brandName');
$model->name = Utils::retrieve_post('name');
$model->totalProducts = Utils::retrieve_post('totalProducts');

try {
    $brand->findOneByName();
    $model->brandId = $brand->id;

    $model->create();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>