<?php

return array(

    'ios'     => array(
        'environment' =>'production',
        'certificate' =>public_path().'/uploads/Production_Certificates.pem',
        'passPhrase'=>'12345',
        'service'     =>'apns'
    ),
    'android' => array(
        'environment' =>'production',
        'apiKey'      =>'AIzaSyAtozjg7Sqs3PU1Ez94RS7NNmom9-QNe24',
        'service'     =>'gcm'
    )

);