<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => true,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAk0RfpaI:APA91bE1RjALmpIqVxYkMjwJFcwt0qc33kenFoXSRKFViw-ax0bFiMf4tleappfY2gHwjs7MuC-jlgsNmZA2-9IRFcUfJyODaDWL6IKwd3uRBt5OXDgNYKFHV9lESSVd9A9oIbK-DFIi'),
        'sender_id' => env('FCM_SENDER_ID', '632507311522'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
