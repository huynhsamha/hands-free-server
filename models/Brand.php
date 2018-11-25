<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Brand extends BasicModel {
    
    private $table_name = 'Brand';
    
    public $id;
    public $name;
    public $iconUri;
    public $totalModels;


    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            name, iconUri, totalModels) VALUES (?, ?, ?)");

        $stmt->bind_param("ssi",
            $this->name,
            $this->iconUri,
            $this->totalModels
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function findOneByName() {
        $res = $this->conn->query("SELECT * FROM $this->table_name WHERE name = '$this->name' limit 1");

        if ($res->num_rows == 0) {
            throw new Error('Brand is not existen. Please check your brand name correctly');
        }

        $data = $res->fetch_assoc();
        $this->fromJSON($data);
    }
}

?>