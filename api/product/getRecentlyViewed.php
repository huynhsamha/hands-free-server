<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_get.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/Product.php';


$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

try {
    $res = $product->findRecentlyViewed();

    http_response_code(200);
    echo json_encode($res);

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>