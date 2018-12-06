<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Model extends BasicModel {
    
    protected $table_name = 'Model';
    
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

    public function createLogical() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            brandId, name) VALUES (?, ?)");

        $stmt->bind_param("isi",
            $this->brandId,
            $this->name
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function findOneByName() {
        $res = $this->conn->query("SELECT * FROM $this->table_name WHERE name = '$this->name' limit 1");

        if ($res->num_rows == 0) {
            throw new Error('Model is not existen. Please check your model name correctly');
        }

        $data = $res->fetch_assoc();
        $this->fromJSON($data);
    }

    public function addOneProduct() {
        $this->totalProducts++;
        $res = $this->conn->query("UPDATE $this->table_name SET totalProducts = $this->totalProducts WHERE id = $this->id");

        if (!$res) throw new Error($res->error);
    }
}

?>