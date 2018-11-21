<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/Model.php';


class Brand extends Model {
    
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
}

?>