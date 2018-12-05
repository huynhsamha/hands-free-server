const fs = require('fs');
const path = require('path');
const axios = require('axios').default;

async function downloadImage(url, uri) {
    const response = await axios({
        method: 'GET',
        url,
        responseType: 'stream'
    })

    response.data.pipe(fs.createWriteStream(uri));

    // return a promise and resolve when download finishes
    return new Promise((resolve, reject) => {
        response.data.on('end', () => {
            resolve()
        })

        response.data.on('error', () => {
            reject()
        })
    })
}

module.exports = downloadImage;