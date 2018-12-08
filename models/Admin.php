<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Admin extends BasicModel {
    
    protected $table_name = 'Admin';
    
    public $id;
    public $username;
    public $password;
    public $salt;

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

    public function checkExistUsername() {
        $res = $this->conn->query("SELECT COUNT(*) as total FROM $this->table_name WHERE username = '$this->username'");
        $data = $res->fetch_assoc();
        $total = $data['total'];
        return $total > 0;
    }

    public function create() {
        if ($this->checkExistUsername()) {
            throw new Error('Username này đã được sử dụng.');
        }

        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            username, password, salt)
            VALUES (?, ?, ?)");

        $stmt->bind_param("sss",
            $this->username,
            $this->password,
            $this->salt
        );

        $this->salt = Admin::generateSalt();
        $this->password = $this->hashPassword($this->password);

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function login() {

        $res = $this->conn->query("SELECT * FROM $this->table_name WHERE username = '$this->username' limit 1");

        if ($res->num_rows == 0) {
            throw new Error('Username này không tồn tại trong hệ thống.');
        }

        $input_password = $this->password;

        $data = $res->fetch_assoc();
        $this->fromJSON($data);

        if ($this->validatePassword($input_password) == false) {
            // throw new Error('Password is not correct. Please check your password correctly');
            throw new Error('Mật khẩu chưa đúng. Vui lòng kiểm tra lại mật khẩu.');
        }

        unset($this->password);
        unset($this->salt);
    }
}

?>