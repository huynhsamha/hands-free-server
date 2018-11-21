<?php

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    header("HTTP/1.0 403 Forbidden");
    print("Forbidden");
    exit();
}

include_once './_common.php';

$cars = mysqli_query($conn, 'SELECT * FROM `cars`');

$res = array();

while ($row = mysqli_fetch_assoc($cars)) {
    array_push($res, $row);
}

mysqli_close($conn);

http_response_code(200);

echo json_encode($res);

?>