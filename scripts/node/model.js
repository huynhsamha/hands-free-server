const axios = require('axios').default;
const async = require('async');
const qs = require('qs');

const data = require('../db/models.json');

async.eachSeries(data, (dt, cb) => {

    // if (dt.brand != 'Hãng khác') return cb();

    console.log(dt)
    const data = qs.stringify({
        brandName: dt.brand,
        name: dt.model || dt.brand,
        totalProducts: 0
    }, {encode: false});
    console.log(data)

    axios.post('http://localhost/hands-free/api/brand/addModelByName.php', data).then(() => cb()).catch(err => cb(err))

}, (err) => {
    if (err) console.log(err);
    else console.log('Success');
    process.exit(0);
})