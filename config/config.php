<?php
$config = [
    "sms_domain" => "https://sms.ru",
    "sms_api_key" => "38A79CCC-B372-4E13-F180-5AB223F3CA6E",
    "sms_test_mode" => 0,
    "bestpay" => [
        "mode" => "test", //установите значение prod для работы в боевом режиме
        "webapi"  => [
            "test" => "https://test.best2pay.net/webapi/",
            "prod" => "https://pay.best2pay.net/webapi/"
        ],
        "sector_id" => "5043",
        "sign_password" => "test"
    ],
    "wirebank" => [
        "partner_email" => "autolombard063@gmail.com",
        "api_key" => "AD0B4BEF-400D-4971-9A99-BE445D5777C2",
        "project_id" => 4233,
        "mode" => "test", //установите значение prod для работы в боевом режиме
        "webapi" => [
            "test" => "https://api.wirebank.ru/v1/",
            "prod" => "https://api.wirebank.ru/v1/"
        ]
    ],
    "vepay" => [
        "login" => "383",
        "key"   => "gk7s6hfLhE6k5PH", 
        "mode" => "test", //установите значение prod для работы в боевом режиме
        "webapi" => [
            "test" => "https://test.vepay.online/",
            "prod" => "https://api.vepay.online/"
        ]
    ]
];