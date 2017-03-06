<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>
<script>
    var socket = io();
    socket.on('notification_test', function (message) {
        console.log(message);
    });
</script>
</body>
</html>