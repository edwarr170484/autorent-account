<?php

$routes = [
    "get" => [
        "main" => [
            "uri" => "/",
            "controller" => "App\Account\Controller\MainController",
            "handler" => "index",
            "firewall" => true
        ]
    ],
    "post" => [

    ]
];