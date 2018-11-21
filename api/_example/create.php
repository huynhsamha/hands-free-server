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
$name = retrieve_post('name');
$year = retrieve_post('year');

if (!is_numeric($id)) $errMessage = "ID should be integer";
else if (strlen($name) < 5 || strlen($name) > 40) $errMessage = "Name should from 5 to 40 characters";
else if (!is_numeric($year) || $year < 1990 || $year > 2015) $errMessage = "Year should be from 1990 to 2015";
else {
    $errMessage = mysqli_query($conn, "INSERT INTO `cars` (`id`, `name`, `year`) VALUES ('$id', '$name', '$year')") ? null : "Error: ".mysqli_error($conn);
}

mysqli_close($conn);

if ($errMessage) {
    http_response_code(400);
    echo json_encode($errMessage);
} else {
    http_response_code(201);
    echo json_encode(array(
        'message' => 'Add new car successfully!',
        'data' => array(
            'id' => $id,
            'name' => $name,
            'year' => $year
        )
    ));
}


?>