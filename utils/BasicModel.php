<?php

abstract class BasicModel {

    protected $conn; # protected field for inheritance

    public function __construct($db) {
        $this->conn = $db;
    }

    public function fromJSON($json) {
        foreach ($json as $key => $val) {
            $this->$key = $val;
        }
    }

    public function findAll() {
        $rows = $this->conn->query("SELECT * FROM $this->table_name");
        $res = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            array_push($res, $row);
        }
        return $res;
    }
}

?>