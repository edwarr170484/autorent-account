<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Payment;

class Wirebank extends Model implements Payment 
{
    public function __construct()
    {
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
            ]
        ];

        $client = $this->auth($this->config("partner_email"), $this->config("api_key"))->post_json($this->config("webapi")[$this->config("mode")] . "payment/create", $params);

        if(!$client->isErrors())
        {
            $order = $client->getJsonResult();

            if($client->getStatusCode() == 200)
            {   
                return ["error" => 0, "url" => $this->getPaymentLink($order)];
            }
            else
            {
                $this->addError($order["message"]);
                return $this->gecorateError($client->getErrors());
            }
            
        }
        else
        {
            return $this->gecorateError($client->getErrors());
        }
    }

    public function getPaymentLink($order)
    {
        return $order["payment_url"];
    }

    public function getName()
    {
        return "wirebank";
    }

    public function config($value)
    {
        return $this->config[$this->getName()][$value];
    }

    public function gecorateError($errors)
    {
        $messages = [];

        if(count($errors["messages"]) > 0)
        {
            foreach($errors["messages"] as $message)
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

        return ["error" => $errors["error"], "messages" => $messages];
    }
}