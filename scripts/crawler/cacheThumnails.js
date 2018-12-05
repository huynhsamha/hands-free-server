const fs = require('fs');
const path = require('path');
const async = require('async');

const downloadImage = require('./downloadImage');

const products = require('./database/shortProducts.json');

let fileNum = 0;

const updated = [];

async.eachSeries(products, (product, cb) => {

    const filename = ++fileNum + '.jpg';
    const url = product.thumbnail;
    const uri = path.join(__dirname, 'images', filename);

    downloadImage(url, uri).then(() => {

        console.log(uri);
        updated.push({
            ...product,
            thumbnail: 'images/cache/' + filename,
            realThumbnail: url
        })
        cb();

    }).catch(err => cb(err))

}, (err) => {
    if (err) console.log(err);
    else console.log('OK');

    fs.writeFileSync('./database/products.json', JSON.stringify(updated, null, 4));

    process.exit(0);
})