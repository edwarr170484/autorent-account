<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Payment;

class BestPay extends Model implements Payment 
{
    public $payment;

    public function __construct()
    {
        $this->payment = null;
        parent::__construct();
    }

    public function createPayment($productId, $amount)
    {   
        $params = [
            "sector" => $this->config("sector_id"),
            "amount" => $amount * 100,
            "currency" => 643,
            "description" => "Пролонгирование договора номер $productId",
            "reference" => $productId,
            "url" => $this->request->getServerName() . "/payment/success",
            "failurl" => $this->request->getServerName() . "/payment/error"
        ];

        $params["signature"] = $this->signature([$params["sector"], $params["amount"], $params["currency"], $this->config("sign_password")]);

        $client = $this->post($this->config("webapi")[$this->config("mode")] . "Register", $params);

        if(!$client->isErrors())
        {
            $ob = simplexml_load_string($client->getResult());
            $json = json_encode($ob);
            $order = json_decode($json, true);

            return ["error" => 0, "url" => $this->getPaymentLink($order)];
        }
        else
        {
            return $client->getErrors();
        }
    }

    public function getPaymentLink($order)
    {
        return $this->config("webapi")[$this->config("mode")] . "Purchase?" . http_build_query([
                "sector" => $this->config("sector_id"),
                "id" => $order["id"],
                "signature" => $this->signature([$this->config("sector_id"), $order["id"], $this->config("sign_password")])
        ]);
    }

    public function getPaymentInformation($paymentId = null)
    {
        $paymentId = $paymentId ? $paymentId : $this->request->get("id");

        if($paymentId)
        {
            $params = [
                "sector" => $this->config("sector_id"),
                "signature" => $this->signature([$this->config("sector_id"), $paymentId, $this->config("sign_password")]),
                "id" => $paymentId
            ];
    
            $client = $this->post($this->config("webapi")[$this->config("mode")] . "Order", $params);
    
            if(!$client->isErrors())
            {
                $ob = simplexml_load_string($client->getResult());
                $json = json_encode($ob);
                $order = json_decode($json, true);
    
                $this->payment = $order;
            }
        }

        return $this->payment;
    }

    public function isPaymentSuccess()
    {
        return $this->payment["state"] == "COMPLETED";
    }

    public function getName()
    {
        return "bestpay";
    }

    public function config($value)
    {
        return $this->config[$this->getName()][$value];
    }

    private function signature($params)
    {
        return base64_encode(md5(implode("",$params)));
    }

    public function __get($name)
    {
        return $this->payment[$name];
    }
}