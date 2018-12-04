<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class OrderDetail extends BasicModel {
    
    protected $table_name = 'OrderDetail';
    
    public $id;
    public $orderId;
    public $productId;
    public $quantity;
    public $unitPrice;
    public $totalPrice;


    public function create() {
        $this->calculateTotalPrice();

        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            orderId, productId, quantity, unitPrice, totalPrice) VALUES (?, ?, ?, ?, ?)");

        $stmt->bind_param("iiiii",
            $this->orderId,
            $this->productId,
            $this->quantity,
            $this->unitPrice,
            $this->totalPrice
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function calculateTotalPrice() {
        $this->totalPrice = $this->unitPrice * $this->quantity;
    }
}

?>