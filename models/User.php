<?php

class User {
    
    private $conn;
    private $table_name = 'User';
    
    public $id;
    public $email;
    public $first_name = '';
    public $last_name = '';
    public $tel = '';
    public $photo_url = '';
    public $address = '';
    public $password;
    public $salt;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    private function generateSalt() {
        $this->salt = bin2hex(random_bytes(32)); 
        # 32 bytes => 32*8 bits
        # to Hex: 32*8/4 (with 1 hex = 4 bits)
    }

    private function hashPassword($password) {
        return hash('sha256', $password . $this->salt);
    }

    public function validatePassword($password) {
        return $this->password == $this->hashPassword($password);
    }

    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            email, first_name, last_name, tel, photo_url, address, password, salt)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("ssssssss",
            $this->email,
            $this->first_name,
            $this->last_name,
            $this->tel,
            $this->photo_url,
            $this->address,
            $this->password,
            $this->salt
        );

        $this->generateSalt();
        $this->password = $this->hashPassword($this->password);

        if (!$stmt->execute()) throw new Error($stmt->error);
    }
}

?>