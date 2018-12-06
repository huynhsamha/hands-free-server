<?php

include_once __DIR__.DIRECTORY_SEPARATOR.'../utils/BasicModel.php';


class Product extends BasicModel {
    
    protected $table_name = 'Product';
    
    public $id;
    public $modelId;
    public $name;
    public $thumbnail;
    public $price;
    // public $priceText;
    public $ceilPrice;
    // public $ceilPriceText;
    public $bestSell;
    public $bestGift;
    public $bestPrice;
    public $hotNew;
    public $hotDeal;
    public $recentlyViewed;
    public $quantity;
    public $status;
    public $warranty;
    public $technicalInfo;
    public $galleryImages;


    public function create() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            modelId, name, thumbnail, price, ceilPrice, 
            bestSell, bestGift, bestPrice, hotNew, hotDeal, recentlyViewed,
            quantity, status, warranty, 
            technicalInfo, galleryImages
        ) VALUES (
            ?,?,?,?,?,
            ?,?,?,?,?,
            ?,?,?,?,?,?)");

        $stmt->bind_param("issiiiiiiiiissss",
            $this->modelId,
            $this->name,
            $this->thumbnail,
            $this->price,
            // $this->priceText,
            $this->ceilPrice,
            // $this->ceilPriceText,
            $this->bestSell,
            $this->bestGift,
            $this->bestPrice,
            $this->hotNew,
            $this->hotDeal,
            $this->recentlyViewed,
            $this->quantity,
            $this->status,
            $this->warranty,
            $this->technicalInfo,
            $this->galleryImages
        );

        if (!$stmt->execute()) throw new Error($stmt->error);
    }

    public function createLogical() {
        $stmt = $this->conn->prepare("INSERT INTO $this->table_name (
            modelId, name, price, ceilPrice, 
            quantity, status, warranty
        ) VALUES (
            ?,?,?,?,?,
            ?,?)");

        $stmt->bind_param("isiiiss",
            $this->modelId,
            $this->name,
            $this->price,
            $this->ceilPrice,
            $this->quantity,
            $this->status,
            $this->warranty
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

    public function findOneByID() {
        $res = $this->conn->query("SELECT p.*, m.name as modelName, b.name as brandName, b.id as brandId 
            FROM Product p, Model m, Brand b 
            WHERE p.id=$this->id and p.modelId = m.id and m.brandId = b.id");
        if ($res->num_rows == 0) {
            throw new Error('Product is not exist. Please check your id correctly');
        }
        $data = $res->fetch_assoc();
        return $data;
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

    public function findHotDeal() {
        return $this->findByAttributeWithJoin('hotDeal', 1);
    }

    public function findRecentlyViewed() {
        return $this->findByAttributeWithJoin('recentlyViewed', 1);
    }

    public function update() {
        $stmt = $this->conn->prepare("UPDATE $this->table_name SET
            modelId = ?, name = ?, thumbnail = ?,
            price = ?, 
            -- priceText = ?,
            ceilPrice = ?, 
            -- ceilPriceText = ?,
            bestSell = ?, bestGift = ?, bestPrice = ?, hotNew = ?, hotDeal = ?, recentlyViewed = ?, 
            quantity = ?, status = ?, warranty = ?,
            technicalInfo = ?, galleryImages = ?
        WHERE id = $this->id");

        $stmt->bind_param("issiiiiiiiiissss",
            $this->modelId,
            $this->name,
            $this->thumbnail,
            $this->price,
            // $this->priceText,
            $this->ceilPrice,
            // $this->ceilPriceText,
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

    /**
     * @param orderType: enum[best_sell, price_asc, price_desc, name]
     */
    public function search($keywords=null, $brandList=null, $minPrice=null, $maxPrice=null, $orderType=null, $page=null) {

        /** Default value for params */
        $keywords = Utils::defaultNull($keywords, '');
        $brandList = Utils::defaultNull($brandList, []);
        $minPrice = Utils::defaultNull($minPrice, 0);
        $maxPrice = Utils::defaultNull($maxPrice, 2000000000);
        $orderType = Utils::defaultNull($orderType, 'best_sell');
        $page = Utils::defaultNull($page, 1);

        $brandList = array_filter($brandList); // removing blank, null, false, 0 (zero) values

        /** Count total products matching */
        $sqlCount = "SELECT count(*) as total from Product p, Model m where p.modelId = m.id ";
        
        $query = "and $minPrice <= p.price and p.price <= $maxPrice and 
            (p.name like '%$keywords%' or m.name like '%$keywords%') ";
        
        if (sizeof($brandList) > 0) {
            $query = $query . "and m.brandId in (".join(', ', $brandList).") ";
        }

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

        /** Sorting */
        $orderColumn = "id";
        $orderDir = "desc";
        switch ($orderType) {
            case 'best_sell':
                $orderColumn = 'bestSell';
            break;
            case 'price_asc':
                $orderColumn = 'price';
                $orderDir = "asc";
            break;
            case 'price_desc':
                $orderColumn = 'price';
                break;
            case 'name':
                $orderColumn = 'name';
                $orderDir = "asc";
                break;
        }
        
        /** Retrieve */
        $sqlRows = "SELECT p.*, m.name as modelName, b.name as brandName, b.id as brandId 
            FROM Product p, Model m, Brand b 
            where p.modelId = m.id and m.brandId = b.id ";
        $sqlRows = $sqlRows . $query . "order by $orderColumn $orderDir limit $onePage offset $offset ";
        
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

    public function updateQuantity() {
        $this->updateSimpleNumberColumns(array('quantity'));
    }
}

?>