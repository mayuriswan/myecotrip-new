<?php

return array(
    // 'internetHandlingCharge' => 4,  #Changed on Dec 3
    'internetHandlingCharge' => 3.5,
    'paymentGatewayCharge' => 2.5,
    'gstCharge' => 18,

    'gstForBook' => 12,

    'gcm_api_key' => '',

    // Live Server final
    'eventHandlingCharge' => 8,

    // local
    'myecotripHTML' => '/Users/vinayan/Sites/Trinity/Myecotrip/Code/myecotrip_new_ui/',
    'imageBaseUrl' => 'http://localhost/Trinity/Myecotrip/Code/myecotrip_new_ui/public',

    // Dev server
    'merchantId'=> 81401,

    //localhost
    // 'workingKey' => 'BF392B8C33C9CC792958E708744F08F0',
    // 'accessCode' => 'AVUQ01EK29BA75QUAB',

    //Development server keys
    'workingKey' => 'BF392B8C33C9CC792958E708744F08F0',
    'accessCode' => 'AVUQ01EK29BA75QUAB',

    //Live server keys
    // 'workingKey' => 'FE6086AB5F89B9EF4873C050ED7186C9',
    // 'accessCode' => 'AVVU07CJ01CE93UVEC',

    'myecotripHTML' => '/var/www/html/myecotrip/',
    'imageBaseUrl' => 'http://13.126.3.49:8080/myecotrip/public',


    'smsReports' => ["8861422700","9611293893","9972077100"],
    'trailAdminEmailSubject' => "Bookings list on ",
    'trailReportExports' => storage_path().'/exports/',

    'bsSmsReport' => ['rfo'=>'9900528905','drfo' => '9341310993', 'dcf' => '9448467028', 'dfo' => '9448467028', 'fg' => '9538143035', 'Imran' => '9886710206'],

    'birdSanctuarySyncAlert' => ['fg' => '9538143035' , 'fg2' => '9886710206', 'fg3' => '9738460424'],

    // MyEcoTrip Demo
     // 'myecotripHTML' => '/var/www/html/myecotripdemo/',
     // 'imageBaseUrl' => 'http://13.126.3.49/myecotripdemo/public',


    'awsAccessKey' => 'AKIAIHPGEKULRVBDROPA',

    'awsSecretKey' => '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',

    's3_bucket' => 'makeuppro-lakmeindia-com',

    's3_baseurl' => 'https://s3-ap-southeast-1.amazonaws.com',

	'create_success_response' => array(
        'content' => array(),
        'response' => array(
            'status-code' => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Successfully created!'
        )
    ),
    'create_failure_response' => array(
        'response' => array(
            'status-code' => 400,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'Failed to create!'
        )
    ),
    'update_failure_response' => array(
        'response' => array(
            'status-code' => 400,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'Update failed'
        )
    ),
    'update_success_response' => array(
        'content' => array(),
        'response' => array(
            'status-code' => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Successfully updated'
        )
    ),
    'retrieve_failure_response' => array(
        'response' => array(
            'status-code' => 400,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'Failed'
        )
    ),
    'retrieve_success_response' => array(
        'content' => array(),
        'response' => array(
            'status-code' => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Success'
        )
    ),
    'login_failure_response' => array(
        'response' => array(
            'status-code' => 401,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'Login Failed'
        )
    ),
    'login_success_response' => array(
        'content' => array(),
        'response' => array(
            'status-code' => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Login Success'
        )
    ),
    'delete_failure_response' => array(
        'response' => array(
            "status-code" => 400,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'Failed to Delete'
        )
    ),
    'delete_success_response' => array(
        'content' => array(),
        'response' => array(
            "status-code" => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Successfully Deleted'
        )
    ),
    'upload_failure_response' => array(
        'response' => array(
            "status-code" => 400,
            'error' => 1,
            'sys_msg'=>'',
            'message' => 'failed'
        )
    ),
    'upload_success_response' => array(
        'content' => array(),
        'response' => array(
            "status-code" => 200,
            'error' => 0,
            'sys_msg'=>'',
            'message' => 'Successfully uploaded'
        )
    ),
    'default_screen_size' => 'hdpi',

    'screen_size' => array('ldpi','mdpi', 'hdpi', 'xhdpi', 'xxhdpi', 'xxxhdpi','4','5','6','6Plus'),

    'resolution'=>array(
        'xxxhdpi' => array('x' => 1440,'y' => 2560),
        'xxhdpi' => array('x' => 1080,'y' => 1920),
        'xhdpi' => array('x' => 720,'y' => 1280),
        'hdpi' => array('x' => 480,'y' => 800),
        'mdpi' => array('x' => 320,'y' => 480),
        'ldpi' => array('x' => 240,'y' => 320),
        '4' => array('x' => 640,'y' => 960),
        '5' => array('x' => 640,'y' => 1136),
        '6' => array('x' => 750,'y' => 1334),
        '6Plus' => array('x' => 1080,'y' => 1920)
    )
);
