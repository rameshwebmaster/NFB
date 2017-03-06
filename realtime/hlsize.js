let ffmpeg = require('fluent-ffmpeg');
let fs = require('fs');
let fileArray = [];
var playlistFileName = "";

module.exports = exports = function (fileName, interval, pfn, se) {
    playlistFileName = pfn;
    if (se) {
        createFinalPlaylist()
    } else {
        convertToMpegts(fileName, interval);
    }
};

function convertToMpegts(fileName, interval) {
    let filePathBase = '../public/live/',
        sourcePath = filePathBase + fileName + '.webm',
        destPath = filePathBase + fileName + '.ts',
        destFileName = fileName + '.ts';

    ffmpeg(sourcePath)
        .addOption('-c:v', 'libx264')
        .addOption('-b:v', '400k')
        .addOption('-preset:v', 'veryfast')
        .addOption('-profile:v', 'main')
        .addOption('-c:a', 'libfdk_aac')
        .addOption('-b:a', '48k')
        .addOption('-ac', '1')
        .addOption('-f', 'mpegts')
        .addOption('-r', '8')
        .on('end', function () {
            console.log('done converting ' + interval);
            ffmpeg.ffprobe(destPath, function (err, metadata) {
                let file = {filename: destFileName, duration: metadata.format.duration};
                fileArray.push(file);
                createPlaylist(interval);
            });
            fs.unlink(sourcePath);
        })
        .on('error', function (error) {
            console.log(error.message);
        })
        .save(destPath);
}

function createPlaylist() {
    console.log('File: ' + playlistFileName);
    let filepath = '../public/playlists/' + playlistFileName;
    let contents = '#EXTM3U' + '\n' +
        '#EXT-X-VERSION:3' + '\n' +
        '#EXT-X-MEDIA-SEQUENCE:0' + '\n' +
        '#EXT-X-PLAYLIST-TYPE:EVENT' + '\n' +
        '#EXT-X-TARGETDURATION:6' + '\n';
    fileArray.forEach(function (fd) {
        contents += '#EXTINF:' + fd.duration + '\n';
        contents += '/live/' + fd.filename + '\n';
        contents += '#EXT-X-DISCONTINUITY' + '\n';
    });
    fs.writeFile(filepath, contents);
}

function createFinalPlaylist() {
    let filepath = '../public/playlists/' + playlistFileName;
    let contents = '#EXTM3U' + '\n' +
        '#EXT-X-VERSION:3' + '\n' +
        '#EXT-X-MEDIA-SEQUENCE:0' + '\n' +
        '#EXT-X-PLAYLIST-TYPE:EVENT' + '\n' +
        '#EXT-X-TARGETDURATION:6' + '\n';
    fileArray.forEach(function (fd) {
        contents += '#EXTINF:' + fd.duration + '\n';
        contents += '/live/' + fd.filename + '\n';
        contents += '#EXT-X-DISCONTINUITY' + '\n';
    });
    contents += "#EXT-X-ENDLIST";
    fs.writeFile(filepath, contents);
}