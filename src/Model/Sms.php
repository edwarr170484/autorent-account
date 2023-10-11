<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;

class Sms extends Model
{
    private $result;

    public function __construct()
    {
        parent::__construct();
        $this->result = [];
    }

    public function send($number, $text)
    {
        $params = [
            "api_id" => $this->config["sms_api_key"],
            "to" => $number,
            "msg" => iconv("windows-1251", "utf-8", $text),
            "json" => 1,
            "test" => $this->config["sms_test_mode"]
        ];

        $client = $this->post($this->config["sms_domain"] . "/sms/send", $params);

        if(!$client->isErrors())
        {
            $result = $client->getJsonResult();

            if($result["status"] == "OK")
            {
                $this->result["error"] = 0;
                $this->result["message"] = "На введенный Вами номер телефона была отправлена SMS с кодом. Введите полученный код в поле ниже";
            }
            else
            {
                $this->result["error"] = 1;
                $this->result["message"] = "Отправка СМС сообщения не удалась. Повторите попытку позже";
            }
        }
        else
        {
            $this->result["error"] = 1;
            $this->result["message"] = "Отправка СМС сообщения не удалась. Повторите попытку позже";
        }

        return $this->result;
    }
}