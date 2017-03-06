var end = 0;

let hlsize = require('./hlsize');
let fs = require('fs');
var playlistFileName = "";


module.exports = exports = function (stream, pfn) {
    playlistFileName = pfn;
    writeToDisk(stream);
};

function writeToDisk(stream) {
    var res = playlistFileName.split(".");
    let filePathBase = '../public/live/',
        fileName = res[0] + '_segment_' + stream.interval,
        fileExt = '.webm',
        filePath = filePathBase + fileName + fileExt;

    let contents = stream.stream.split(',').pop();

    let fileBuffer = new Buffer(contents, "base64");

    fs.writeFile(filePath, fileBuffer, {encoding: 'base64'}, function (error) {
        if (error) throw error;
        end++;
        hlsize(fileName, stream.interval, playlistFileName, false);
    });
}

