<?php

if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("HTTP/1.0 403 Forbidden");
    print("Forbidden");
    exit();
}

header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once './_common.php';


$id = retrieve_post('id');

$errMessage = mysqli_query($conn, "DELETE FROM `cars` WHERE `cars`.`id` = $id") ? null : "Error: ".mysqli_error($conn);

mysqli_close($conn);

if ($errMessage) {
    http_response_code(400);
    echo json_encode($errMessage);
} else {
    http_response_code(200);
    echo json_encode(array(
        'message' => 'Delete car successfully!'
    ));
}


?>