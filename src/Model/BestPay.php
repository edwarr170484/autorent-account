<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Payment;
use Webwarrd\Core\Error;

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

        if(!Error::is())
        {
            $ob = simplexml_load_string($client->getResult());
            $json = json_encode($ob);
            $order = json_decode($json, true);

            $this->session->paymentId = $order["id"];

            return ["error" => 0, "url" => $this->getPaymentLink($order)];
        }
        else
        {
            return ["error" => 1, "messages" => $this->errors()];
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
        $paymentId = $paymentId ? $paymentId : $this->session->paymentId;

        if($paymentId)
        {
            $params = [
                "sector" => $this->config("sector_id"),
                "signature" => $this->signature([$this->config("sector_id"), $paymentId, $this->config("sign_password")]),
                "id" => $paymentId
            ];
    
            $client = $this->post($this->config("webapi")[$this->config("mode")] . "Order", $params);
    
            if(!Error::is())
            {
                $ob = simplexml_load_string($client->getResult());
                $json = json_encode($ob);
                $order = json_decode($json, true);
    
                $this->payment = $order;
            }
        }

        return $this->payment;
    }

    public function getPaymentProduct()
    { 
        return $this->payment["reference"];
    }

    public function getPaymentAmount()
    { 
        return ((float)$this->payment["amount"] / 100);
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

    public function errors()
    {
        return Error::list();
    }
}