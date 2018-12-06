<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../../models/Model.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'../../../models/Brand.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../middleware.php';

/**
 * Thêm một model của 1 brand
 * 
 * POST
 *  Headers:
 *      + Authorization: token (String)
 *  Body:
 *      + brandId: (int) // ID của brand
 *      + name: (String) // Tên của model
 */

$database = new Database();
$db = $database->getConnection();

$brand = new Brand($db);
$model = new Model($db);

$brand->id = Utils::retrieve_post('brandId');
$model->name = Utils::retrieve_post('name');

try {
    checkAuthorized();

    $brand->findByID();

    $model->brandId = $brand->id;

    $model->createLogical();

    $brand->addOneModel();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>