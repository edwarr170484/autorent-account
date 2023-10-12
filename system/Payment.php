<?php
namespace Webwarrd\Core;

interface Payment{
    public function createPayment($productId, $amount);
    public function getPaymentLink($order);
    public function getPaymentInformation($paymentId = null);
    public function isPaymentSuccess();
    public function getName();
    public function config($value);
}