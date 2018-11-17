<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

$email = retrieve_post('email');
$first_name = retrieve_post('first_name');
$last_name = retrieve_post('last_name');
$tel = retrieve_post('tel');
$address = retrieve_post('address');
$password = retrieve_post('password');

$salt = bin2hex(random_bytes(32)); # 32 bytes => 32*8 bits => hex: 32*8/4 (1 hex = 4 bits)
$password = hash('sha256', $password . $salt);

echo json_encode(array(
    'email' => $email,
    'password' => $password,
    'salt' => $salt
));

?>