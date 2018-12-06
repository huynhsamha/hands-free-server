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
    public $createdAt;

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

    public function updateAvatar() {
        $this->updateSimpleStringColumns(array('photoUrl'));
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

    public function search($keywords=null, $page=null) {

        /** Default value for params */
        $keywords = Utils::defaultNull($keywords, '');
        $page = Utils::defaultNull($page, 1);

        /** Count total products matching */
        $sqlCount = "SELECT count(*) as total from User ";

        $attrList = array('id', 'email', 'firstName', 'lastName', 'tel', 'address');
        $queryList = array();
        foreach ($attrList as $attr) array_push($queryList, " $attr like '%$keywords%' ");
        $query = " where " . join(" or ", $queryList);
        
        $sqlCount = $sqlCount . $query;
        $total = $this->conn->query($sqlCount);
        if (!$total) throw new Error('Error SQL query statement.');
        $total = $total->fetch_assoc()['total'];

        /** Paging */
        $onePage = 20;
        $minPage = 1;
        $maxPage = floor(($total + $onePage - 1) / $onePage);
        $page = min($page, $maxPage);
        $page = max($page, $minPage);
        $offset = $onePage * ($page - 1);
        
        /** Retrieve */
        $sqlRows = "SELECT * FROM ProtectUser ";
        $sqlRows = $sqlRows . $query . " limit $onePage offset $offset ";
        
        $rows = $this->conn->query($sqlRows);
        $res = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            array_push($res, $row);
        }

        return array(
            'total' => $total,
            'page' => $page,
            'onePage' => $onePage,
            'totalPage' => $maxPage,
            'offset' => $offset,
            'data' => $res
        );
    }
}

?>