<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../_post.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../../models/User.php';

include_once __DIR__.DIRECTORY_SEPARATOR.'../auth/middleware.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);


$file = $_FILES["avatar"];
/**
 * @var $file = $_FILES["avatar"]:
 * {
 *   "name": "abc123xyz.jpg",
 *   "type": "image/jpeg",
 *   "tmp_name": "/opt/lampp/temp/phpynrKU5",
 *   "error": 0,
 *   "size": 79298
 * }
 */

$target_dir = realpath(dirname(__FILE__)) . '/../../uploads/';
$target_filename = 'IMG_' . time() . '_' . basename($file["name"]);
$target_file = $target_dir . $target_filename;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

try {
    $data = checkAuthorized();

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check == false) {
        throw new Error('File tải lên không phải là file ảnh.');
    }

    // Check file size 500KB
    if ($file["size"] > 500000) {
        throw new Error('Kích thước file quá lớn.');
    }

    // Allow certain file formats
    if (!in_array($imageFileType, array('jpg', 'png', 'jpeg'))) {
        throw new Error('Chỉ hỗ trợ các file ảnh jpg, jpeg, png.');
    }

    // Upload
    if (!move_uploaded_file($file["tmp_name"], $target_file)) {
        throw new Error('Đã có lỗi xảy ra trong quá trình upload. Xin vui lòng thử lại.');
    }

    http_response_code(200);
    echo json_encode(array(
        'message' => 'Upload successfully',
        'url' => 'uploads/' . $target_filename
    ));

} catch (Error $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());

} catch (Exception $err) {
    http_response_code(400);
    echo json_encode($err->getMessage());
}

?>