<?php
namespace Webwarrd\Core;

interface Payment{
    public function createPayment($productId, $amount);
    public function getPaymentLink($order);
    public function getName();
}