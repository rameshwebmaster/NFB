let io;
let apn = require('apn');
let options = {
    token: {
        key: "apns.p8",
        keyId: "433Y68CZZT",
        teamId: "BV8QSQ29JH"
    },
    production: false
};

let apnProvider = new apn.Provider(options);

module.exports = exports = function (message, socket) {
    io = socket;
    io.emit('notification_test', 'adfafdF');
    handleNotification(message);
};


function handleNotification(message) {

    let currentUser = message.user;
    if (currentUser.platform == 'ios' && currentUser.deviceToken != 'NO_TOKEN') {
        console.log("sending To iOS User " + currentUser.username);
        let deviceToken = currentUser.deviceToken;
        let note = new apn.Notification();
        note.expiry = Math.floor(Date.now() / 1000) + 3600; // Expires 1 hour from now.
        note.badge = 1;
        note.sound = "ping.aiff";
        note.alert = message.payload.subject;
        note.payload = {'message': 'App'};
        note.topic = "com.tds.nfbox";

        apnProvider.send(note, deviceToken).then( (result) => {
            // see documentation for an explanation of result
        });
    } else {
        console.log("sending To android User " + currentUser.username);
        sendToAndroidUser(currentUser.username, message.payload);
    }
}

function sendToAndroidUser(username, payload) {
    io.emit('notification_' + username, payload);
}
