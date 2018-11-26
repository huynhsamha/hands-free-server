const axios = require('axios').default;
const async = require('async');
const qs = require('qs');

const data = require('../db/brands.json');

async.eachSeries(data, (dt, cb) => {

    console.log(dt)
    const data = qs.stringify({
        name: dt.brand,
        iconUri: dt.icon,
        totalModels: 0
    });
    console.log(data)

    axios.post('http://localhost/hands-free/api/brand/create.php', data).then(() => cb()).catch(err => cb(err))

}, (err) => {
    if (err) console.log(err);
    else console.log('Success');
    process.exit(0);
})