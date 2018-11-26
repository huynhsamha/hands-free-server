const axios = require('axios').default;
const async = require('async');
const qs = require('qs');

let data = require('../db/shortProducts.json');
const demo = require('../db/detailProducts.json')[1];

// data = [data[1]] 

async.eachSeries(data, (dt, cb) => {

    console.log(dt)
    const data = qs.stringify({
        modelName: dt.model || dt.brand,
        name: dt.name, 
        thumbnail: dt.thumbnail,
        price: dt.price,
        priceText: dt.priceText,
        ceilPrice: dt.ceilPrice,
        ceilPriceText: dt.ceilPriceText,
        bestSell: dt.bestSell,
        bestGift: dt.bestGift,
        bestPrice: dt.bestPrice,
        hotNew: dt.hostNew,
        quantity: Math.floor(Math.random() * 300),
        status: demo.status,
        warranty: demo.warranty,
        technicalInfo: JSON.stringify(demo.technicalInfo),
        galleryImages: JSON.stringify(demo.galleryImages)
    });
    console.log(data)

    axios.post('http://localhost/hands-free/api/model/addProductByName.php', data).then(() => cb()).catch(err => cb(err))

}, (err) => {
    if (err) console.log(err);
    else console.log('Success');
    process.exit(0);
})