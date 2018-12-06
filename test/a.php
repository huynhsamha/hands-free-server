<?php

// phpinfo();

if (!in_array('jpg', array('jpg', 'png', 'jpeg'))) {
    echo 'no';
} else {
    echo 'yes';
}

// $var = '<script>&quotHello "World" why</script>';

// echo strip_tags($var);
// echo htmlspecialchars($var);
// echo htmlspecialchars(strip_tags($var));

// $var = '[{"name":"Hãng sản xuất:","value":"OPPO"},{"name":"3G:","value":"HSPA 42.2/5.76 Mbps"},{"name":"4G:","value":"LTE-A (6CA) Cat18 1200/200 Mbps"},{"name":"Kích thước:","value":"156.7 x 74.2 x 9.6 mm (6.17 x 2.92 x 0.38 in)"},{"name":"Trọng lượng:","value":"186 g (6.56 oz)"},{"name":"Loại SIM:","value":"2 SIM (Nano-SIM)"},{"name":"Loại màn hình:","value":"Cảm ứng điện dung AMOLED, 16 triệu màu"},{"name":"Kích thước màn hình:","value":"6.42 inches"},{"name":"Độ phân giải màn hình:","value":"1080 x 2340 pixels"},{"name":"Hệ điều hành:","value":"Android"},{"name":"Phiên bản hệ điều hành:","value":"8.1 (Oreo)"},{"name":"Chipset:","value":"Qualcomm SDM845 Snapdragon 845"},{"name":"CPU:","value":"4x 2.8 GHz Kryo 385 Gold & 4x 1.7 GHz Kryo 385 Silver"},{"name":"GPU:","value":"Adreno 630"},{"name":"Khe cắm thẻ nhớ:","value":"microSD, lên đến 400 GB"},{"name":"Bộ nhớ đệm / Ram:","value":"256 GB, 8 GB RAM"},{"name":"Camera sau:","value":"16 MP (f/2.0, PDAF, OIS) + 20 MP (f/2.0), tự động lấy nét nhận diện theo giai đoạn, LED flash kép (2 tone)"},{"name":"Camera trước:","value":"2160p@30fps"},{"name":"Quay video:","value":"25 MP (f/2.0)"},{"name":"WLAN:","value":"Wi-Fi 802.11 a/b/g/n/ac, dual-band, WiFi Direct, hotspot"},{"name":"Bluetooth:","value":"5.0, A2DP, LE"},{"name":"GPS:","value":"A-GPS, GLONASS, BDS"},{"name":"NFC:","value":"Yes"},{"name":"USB:","value":"2.0, Type-C 1.0, USB On-The-Go"},{"name":"Cảm biến:","value":"Face ID, gia tốc, con quay hồi chuyển, khoảng cách, la bàn"},{"name":"Pin:","value":"Li-ion 3730 mAh"}]';

// echo strip_tags($var);


// $a = "true" == "false" ? 1 : 0;
// echo $a;
// echo $a === null;
// echo false === null;

// $keywords = "sony";
// $brandList = [103, 105];
// $minPrice = 3000000; 
// $maxPrice = 25000000;
// $orderType;

// $sqlCount = "SELECT count(*) as total ";
// $sqlRows  = "SELECT p.*, m.name as modelName, b.name as brandName, b.id as brandId ";
// $query = "from Product p, Model m, Brand b where p.modelId = m.id and m.brandId in (".join(', ', $brandList).") and 
//             $minPrice <= p.price and p.price <= $maxPrice and (p.name like '%$keywords%' or m.name like '%$keywords%')
//             order by ";

// echo $sqlCount . $query;

// $onePage = 20;
// $page = 6;
// $total = 141;
// $minPage = 1;
// $maxPage = floor(($total + $onePage - 1) / $onePage);
// $page = min($page, $maxPage);
// $page = max($page, $minPage);
// $offset = $onePage * ($page - 1);

// echo $maxPage, $page, $offset;

?>