<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Payment;
use Webwarrd\Core\Error;

class Vepay extends Model implements Payment 
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
            "amount" => 100,
            "extid" => $productId,
            "descript" => "Пролонгирование договора номер $productId",
            "timeout" => 11,
            "successurl" => $this->request->getServerName() . "/payment/success",
            "failurl" => $this->request->getServerName() . "/payment/error"
        ];

        $client = $this->add_custom_header("X-Login", $this->config("login"))
                       ->add_custom_header("X-Token", $this->signature($this->config("key"), json_encode($params)))
                       ->post_json($this->config("webapi")[$this->config("mode")] . "pay/lk", $params);

        if(!Error::is())
        {
            $order = $client->getJsonResult();

            if($client->getStatusCode() == 200)
            {   
                $this->session->paymentId = $order["id"];
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
        return $order["url"];
    }

    public function getPaymentInformation($paymentId = null)
    {
        $paymentId = $paymentId ? $paymentId : $this->session->paymentId;

        if($paymentId)
        {
            $params = [
                "id" => $this->session->paymentId
            ];

            $client = $this->add_custom_header("X-Login", $this->config("login"))
                       ->add_custom_header("X-Token", $this->signature($this->config("key"), json_encode($params)))
                       ->post_json($this->config("webapi")[$this->config("mode")] . "pay/info", $params);

            if(!Error::is())
            {
                $this->payment = $client->getJsonResult();   
            }
        }

        return $this->payment;
    }

    public function isPaymentSuccess()
    {
        return $this->payment["status"] == 1;
    }

    public function getName()
    {
        return "vepay";
    }

    public function config($value)
    {
        return $this->config[$this->getName()][$value];
    }

    private function signature($key, $data)
    {
        return sha1(sha1($key).sha1($data));
    }
    public function errors()
    {
        $messages = [];

        if(Error::is())
        {
            foreach(Error::list() as $message)
            {
                $arr = json_decode($message, true);

                if(is_array($arr))
                {
                    if(count($arr) > 0)
                    {
                        array_push($messages, $arr["message"]);
                    }
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