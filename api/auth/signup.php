<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

$email = retrieve_post('email');
$username = retrieve_post('username');
$password = retrieve_post('password');
$first_name = retrieve_post('first_name');
$last_name = retrieve_post('last_name');
$tel = retrieve_post('tel');

echo json_encode(array(
    'username' => $username,
    'email' => $email,
    'password' => $password
));

?>