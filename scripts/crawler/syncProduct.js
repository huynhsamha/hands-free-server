const fs = require('fs');
const path = require('path');
const products1 = require('./database/shortProducts.json');
const products = require('./database/products.json');

for (let i=0;i<products.length;i++) {
    products[i] = {...products1[i], ...products[i]};
}

fs.writeFileSync('./database/productsFix.json', JSON.stringify(products, null, 4));
