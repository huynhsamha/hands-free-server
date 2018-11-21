<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Model extends BasicModel {
    
    private $table_name = 'Model';
    
    public $id;
    public $brandId;
    public $name;
    public $totalProducts;


    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            brandId, name, totalProducts) VALUES (?, ?, ?)");

        $stmt->bind_param("isi",
            $this->brandId,
            $this->name,
            $this->totalProducts
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }
}

?>