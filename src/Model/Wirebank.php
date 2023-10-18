<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Payment;
use Webwarrd\Core\Error;

class Wirebank extends Model implements Payment 
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
            "order" => [
                "currency" => "RUB",
                "amount" => $amount,
                "description" => "Пролонгирование договора номер $productId"
            ],
            "settings" => [
                "project_id" => $this->config("project_id"),
                "payment_method" => "card",
                "success_url" => $this->request->getServerName() . "/payment/success",
                "fail_url" => $this->request->getServerName() . "/payment/error"
            ],
            "custom_parameters" => [
                "reference" => $productId
            ]
        ];

        $client = $this->auth($this->config("partner_email"), $this->config("api_key"))->post_json($this->config("webapi")[$this->config("mode")] . "payment/create", $params);

        if(!Error::is())
        {
            $order = $client->getJsonResult();

            if($client->getStatusCode() == 200)
            {   
                $this->session->paymentId = $order["token"];
                return ["error" => 0, "url" => $this->getPaymentLink($order)];
            }
            else
            {
                return ["error" => 1, "messages" => $this->errors()];
            }
            
        }
        else
        {
            return ["error" => 1, "messages" => $this->errors()];
        }
    }

    public function getPaymentLink($order)
    {
        return $order["payment_url"];
    }
    
    public function getPaymentInformation($paymentId = null)
    {
        $paymentId = $paymentId ? $paymentId : $this->session->paymentId;

        if($paymentId)
        {
            $params = [
                "token" => $this->session->paymentId
            ];

            $client = $this->auth($this->config("partner_email"), $this->config("api_key"))->post_json($this->config("webapi")[$this->config("mode")] . "payment/get", $params);

            if(!Error::is())
            {
                $this->payment = $client->getJsonResult();   
            }
        }

        return $this->payment;
    }

    public function getPaymentProduct()
    { 
        return $this->payment["custom_parameters"]["reference"];
    }

    public function getPaymentAmount()
    { 
        return $this->payment["order"]["amount"];
    }

    public function isPaymentSuccess()
    {
        return $this->payment["status"] == "successful";
    }

    public function getName()
    {
        return "wirebank";
    }

    public function config($value)
    {
        return $this->config[$this->getName()][$value];
    }

    public function errors()
    {
        $messages = [];

        if(Error::is())
        {
            foreach(Error::list() as $message)
            {
                $arr = json_decode($message, true);

                if(count($arr) > 0)
                {
                    array_push($messages, $arr["message"]);
                }
                else
                {
                    array_push($messages, $message);
                }
            }
        }

        return ["error" => 1, "messages" => $messages];
    }
}