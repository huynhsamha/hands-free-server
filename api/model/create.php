<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Model.php';


$database = new Database();
$db = $database->getConnection();

$model = new Model($db);

$model->brandId = Utils::retrieve_post('brandId');
$model->name = Utils::retrieve_post('name');
$model->totalProducts = Utils::retrieve_post('totalProducts');

try {
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