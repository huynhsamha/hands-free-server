const axios = require('axios').default;
const async = require('async');
const qs = require('qs');

const data = require('../db/users.json');

async.eachSeries(data, (dt, cb) => {

    console.log(dt)
    const data = qs.stringify(dt);

    axios.post('http://localhost/hands-free/api/auth/signup.php', data).then(() => cb()).catch(err => cb(err))

}, (err) => {
    if (err) console.log(err);
    else console.log('Success');
    process.exit(0);
})