<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class User extends BasicModel {
    
    protected $table_name = 'User';
    
    public $id;
    public $email;
    public $firstName = '';
    public $lastName = '';
    public $tel = '';
    public $photoUrl = '';
    public $address = '';
    public $password;
    public $salt;
    public $created_at;

    public static function generateSalt() {
        # random_bytes => 32 bytes => 32*8 bits
        # to Hex: 32*8/4 (with 1 hex = 4 bits) = length 64
        return bin2hex(random_bytes(32)); 
    }

    private function hashPassword($password) {
        return hash('sha256', $password . $this->salt);
    }

    public function validatePassword($password) {
        return $this->password == $this->hashPassword($password);
    }

    public function checkExistEmail() {
        $res = $this->conn->query("SELECT COUNT(*) as total FROM $this->table_name WHERE email = '$this->email'");
        $data = $res->fetch_assoc();
        $total = $data['total'];
        return $total > 0;
    }

    public function create() {
        if ($this->checkExistEmail()) {
            // throw new Error('Email is existen. You can forgot password to reset.');
            throw new Error('Địa chỉ Email này đã được sử dụng. Bạn có thể yêu cầu gửi lại email để thay đổi mật khẩu.');
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            email, firstName, lastName, tel, photoUrl, address, password, salt)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssss",
            $this->email,
            $this->firstName,
            $this->lastName,
            $this->tel,
            $this->photoUrl,
            $this->address,
            $this->password,
            $this->salt
        );

        $this->salt = User::generateSalt();
        $this->password = $this->hashPassword($this->password);

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function login() {

        $res = $this->conn->query("SELECT * FROM $this->table_name WHERE email = '$this->email' limit 1");

        if ($res->num_rows == 0) {
            // throw new Error('Email is not existen. Please check your email correctly');
            throw new Error('Địa chỉ email này không tồn tại trong hệ thống. Vui lòng kiểm tra lại email hoặc tạo tài khoản mới.');
        }

        $input_password = $this->password;

        $data = $res->fetch_assoc();
        $this->fromJSON($data);

        if ($this->validatePassword($input_password) == false) {
            // throw new Error('Password is not correct. Please check your password correctly');
            throw new Error('Mật khẩu chưa đúng. Vui lòng kiểm tra lại mật khẩu.');
        }

        $this->password = null;
        $this->salt = null;
    }

    public function updateInfo() {
        $this->updateSimpleStringColumns(array('firstName', 'lastName', 'tel', 'address'));
    }

    public function getProfile() {
        $this->findByID();
        $this->password = null;
        $this->salt = null;
    }

    public function changePassword($oldPassword, $newPassword) {
        $this->findByID();

        if ($this->validatePassword($oldPassword) == false) {
            // throw new Error('Password is not correct. Please check your password correctly');
            throw new Error('Mật khẩu chưa đúng. Vui lòng kiểm tra lại mật khẩu.');
        }

        $this->salt = User::generateSalt();
        $this->password = $this->hashPassword($newPassword);

        $this->updateSimpleStringColumns(array('password', 'salt'));
    }
}

?>