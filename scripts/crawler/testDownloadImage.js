const fs = require('fs');
const path = require('path');

const downloadImage = require('./downloadImage');

const url = 'https://cellphones.com.vn/media/catalog/product/cache/7/small_image/220x175/9df78eab33525d08d6e5fb8d27136e95/r/e/redmi-s2-gold_2.jpg';

const uri = path.join(__dirname, './images', '1.jpg');

downloadImage(url, uri).then(() => console.log('OK')).catch(err => console.log(err))