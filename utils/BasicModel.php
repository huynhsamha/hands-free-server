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

    public function mergeNew($json) {
        foreach ($json as $key => $val) {
            if ($key == 'id' || $val === null) continue;
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

    public function findByAttribute($attr, $value) {
        $rows = $this->conn->query("SELECT * FROM $this->table_name where $attr=$value");
        $res = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            array_push($res, $row);
        }
        return $res;
    }

    public function findByID() {
        $res = $this->conn->query("SELECT * FROM $this->table_name WHERE id = '$this->id'");

        if ($res->num_rows == 0) {
            throw new Error('Item is not existen. Please check your id correctly');
        }

        $data = $res->fetch_assoc();
        $this->fromJSON($data);
    }

}

?>