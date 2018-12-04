<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class OrderInfo extends BasicModel {
    
    protected $table_name = 'OrderInfo';
    
    public $id;
    public $userId;
    public $orderTime;
    public $approveTime;
    public $completeTime;
    public $status;
    public $paymentAddress;
    public $paymentMethod;
    public $totalPrice;


    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            userId, paymentAddress, paymentMethod) VALUES (?, ?, ?)");

        $stmt->bind_param("iss",
            $this->userId,
            $this->paymentAddress,
            $this->paymentMethod
        );

        if (!$stmt->execute()) throw new Error($stmt->error);

        $this->id = $this->conn->insert_id;
    }

    public function updateTotalPrice() {
        $res = $this->conn->query("UPDATE $this->table_name SET totalPrice = $this->totalPrice WHERE id = $this->id");

        if (!$res) throw new Error($res->error);
    }
}

?>