<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Product.php';


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$queries = Utils::retrieve_queries();
$product->id = Utils::retrieve_field($queries, 'id');

try {
    $res = $product->findOneByID();

    http_response_code(200);
    echo json_encode($res);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>