<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Product extends BasicModel {
    
    protected $table_name = 'Product';
    
    public $id;
    public $modelId;
    public $name;
    public $thumbnail;
    public $price;
    public $priceText;
    public $ceilPrice;
    public $ceilPriceText;
    public $bestSell;
    public $bestGift;
    public $bestPrice;
    public $hotNew;
    public $quantity;
    public $status;
    public $warranty;
    public $technicalInfo;
    public $galleryImages;


    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            modelId, name, thumbnail, price, priceText, 
            ceilPrice, ceilPriceText,
            bestSell, bestGift, bestPrice, hotNew, 
            quantity, status, warranty, 
            technicalInfo, galleryImages
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        $stmt->bind_param("issisisiiiiissss",
            $this->modelId,
            $this->name,
            $this->thumbnail,
            $this->price,
            $this->priceText,
            $this->ceilPrice,
            $this->ceilPriceText,
            $this->bestSell,
            $this->bestGift,
            $this->bestPrice,
            $this->hotNew,
            $this->quantity,
            $this->status,
            $this->warranty,
            $this->technicalInfo,
            $this->galleryImages
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function findByAttributeWithJoin($attr, $value) {
        $rows = $this->conn->query("SELECT p.*, m.name as modelName, b.name as brandName, b.id as brandId 
            FROM Product p, Model m, Brand b 
            WHERE $attr=$value and p.modelId = m.id and m.brandId = b.id");
        $res = array();
        while ($row = mysqli_fetch_assoc($rows)) {
            array_push($res, $row);
        }
        return $res;
    }

    public function findBestSell() {
        return $this->findByAttributeWithJoin('bestSell', 1);
    }

    public function findBestGift() {
        return $this->findByAttributeWithJoin('bestGift', 1);
    }

    public function findBestPrice() {
        return $this->findByAttributeWithJoin('bestPrice', 1);
    }

    public function findHotNew() {
        return $this->findByAttributeWithJoin('hotNew', 1);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE $this->table_name SET
            modelId = ?, name = ?, thumbnail = ?,
            price = ?, priceText = ?,
            ceilPrice = ?, ceilPriceText = ?,
            bestSell = ?, bestGift = ?, bestPrice = ?, hotNew = ?, 
            quantity = ?, status = ?, warranty = ?,
            technicalInfo = ?, galleryImages = ?
        WHERE id = $this->id");

        $stmt->bind_param("issisisiiiiissss",
            $this->modelId,
            $this->name,
            $this->thumbnail,
            $this->price,
            $this->priceText,
            $this->ceilPrice,
            $this->ceilPriceText,
            $this->bestSell,
            $this->bestGift,
            $this->bestPrice,
            $this->hotNew,
            $this->quantity,
            $this->status,
            $this->warranty,
            $this->technicalInfo,
            $this->galleryImages
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }
}

?>