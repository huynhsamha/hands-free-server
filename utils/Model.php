<?php

abstract class Model {

    protected $conn; # protected field for inheritance

    public function __construct($db) {
        $this->conn = $db;
    }

    public function fromJSON($json) {
        foreach ($json as $key => $val) {
            $this->$key = $val;
        }
    }

}

?>