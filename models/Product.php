<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Product extends BasicModel {
    
    private $table_name = 'Product';
    
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
}

?>