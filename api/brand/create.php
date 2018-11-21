<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Brand.php';


$database = new Database();
$db = $database->getConnection();

$brand = new Brand($db);

$brand->name = Utils::retrieve_post('name');
$brand->iconUri = Utils::retrieve_post('iconUri');
$brand->totalModels = Utils::retrieve_post('totalModels');

try {
    $brand->create();

    http_response_code(201);
    echo json_encode(array(
        'message' => 'Create successfully'
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>