let app = require('http').createServer();
let io = require('socket.io')(app);
let redis = require('ioredis')();
let notifier = require('./notification');
let hlsize = require('./hlsize');
let writeToDisk = require('./writeToDisk');

let questions = [];

var playlistFileName = "";

var streamStarted = false;

app.listen(8080, '127.0.0.1');

io.on('connection', function (socket) {

    if (streamStarted) {
        setTimeout(function () {
            socket.emit('stream_start', {
                filename: "https://nfbox-kw.com/playlists/" + playlistFileName,
                doctor: "John Doe"
            });
        }, 5000);
    }

    socket.on('stream_question', function (message) {
        console.log('Question Received');
        // console.log(message);
        //message = JSON.parse(message);
        if (streamStarted) {
            questions.push(message);
            socket.broadcast.emit('stream_question', message);
        }
    });

    socket.on('stream', function (stream) {
        console.log('Stream interval ' + stream.interval + ' received');
        writeToDisk(stream, playlistFileName);
    });
    socket.on('disconnect', function () {
        console.log('a user disconnected');
    });
});

redis.subscribe('nfbox:notification');
redis.subscribe('nfbox:stream_start');
redis.subscribe('nfbox:stream_end');

redis.on('message', function (channel, message) {
    if (channel == 'nfbox:notification') {
        console.log('Message Recieved');
        message = JSON.parse(message);
        notifier(message, io);
    } else if (channel == 'nfbox:stream_start') {
        console.log('Stream Started');
        message = JSON.parse(message);
        playlistFileName = message.filename;
        console.log(playlistFileName);
        setTimeout(function () {
            io.emit('stream_start', {
                filename: "https://nfbox-kw.com/playlists/" + playlistFileName,
                doctor: "John Doe"
            });
            streamStarted = true;
        }, 15000);
    } else if (channel == 'nfbox:stream_end') {
        console.log('Stream Ended');
        io.emit('stream_end', {status: 'ended'});
        streamStarted = false;
        setTimeout(function () {
            hlsize("", "", playlistFileName, true);
            playlistFileName = "";
            questions = [];
        }, 10000);
    }

});
