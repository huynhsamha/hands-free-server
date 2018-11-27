<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Product.php';


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$queries = Utils::retrieve_queries();

try {
    $res = $product->search(
        Utils::retrieve_field($queries, 'keywords'),
        $queries['brandList'], // array type
        Utils::retrieve_field($queries, 'minPrice'),
        Utils::retrieve_field($queries, 'maxPrice'),
        Utils::retrieve_field($queries, 'orderType'),
        Utils::retrieve_field($queries, 'page')
    );

    http_response_code(200);
    echo json_encode($res);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>