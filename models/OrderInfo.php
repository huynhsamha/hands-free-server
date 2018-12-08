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

    public function findAllByUser() {
        $rows = $this->conn->query("SELECT * FROM $this->table_name where userId = $this->userId");
        $res = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            array_push($res, $row);
        }
        return $res;
    }

    public function checkIsOwner($userId) {
        $this->findByID();
        if ($this->userId != $userId) throw new Error('Bạn không có quyền xem đơn hàng này.');
    }

    public function approveStatus() {
        $this->status = "Approved";
        $this->updateSimpleStringColumns(array('status'));
    }

    public function completeStatus() {
        $this->status = "Completed";
        $this->updateSimpleStringColumns(array('status'));
    }

    public function search($keywords=null, $page=null) {

        /** Default value for params */
        $keywords = Utils::defaultNull($keywords, '');
        $page = Utils::defaultNull($page, 1);

        /** Count total products matching */
        $sqlCount = "SELECT count(*) as total from $this->table_name ";

        $attrList = array('id', 'userId', 'status', 'paymentAddress', 'paymentMethod');
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
        $sqlRows = "SELECT * FROM $this->table_name ";
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