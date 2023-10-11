<?php

$routes = [
    "login" => [
        "uri" => "/login",
        "controller" => "Security",
        "handler" => "index",
        "firewall" => false
    ],
    "sms" => [
        "uri" => "/login/sms",
        "controller" => "Security",
        "handler" => "sms",
        "firewall" => false
    ],
    "auth" => [
        "uri" => "/login/auth",
        "controller" => "Security",
        "handler" => "auth",
        "firewall" => false
    ],
    "logout" => [
        "uri" => "/logout",
        "controller" => "Security",
        "handler" => "logout",
        "firewall" => false
    ],
    "main" => [
        "uri" => "/",
        "controller" => "Main",
        "handler" => "index",
        "firewall" => true
    ],
    "history" => [
        "uri" => "/history",
        "controller" => "Main",
        "handler" => "history",
        "firewall" => true
    ],
    "payment_create" => [
        "uri" => "/payment/create",
        "controller" => "Payment",
        "handler" => "create",
        "firewall" => true
    ],
    "payment_success" => [
        "uri" => "/payment/success",
        "controller" => "Payment",
        "handler" => "success",
        "firewall" => true
    ],
    "payment_success" => [
        "uri" => "/payment/error",
        "controller" => "Payment",
        "handler" => "error",
        "firewall" => true
    ],
];