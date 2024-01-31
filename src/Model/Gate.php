<?php
namespace App\Account\Model;

use Webwarrd\Core\Model;
use Webwarrd\Core\Error;

class Gate extends Model
{
    public function getUidByPhone($phone)
    {
        $result = $this->auth("Site_Exchange", "dS-89eoeX_")->get("https://1c.pobeda-corp.com:4433/uf_static_test/hs/API/Partner?phone=" . $phone);

        return (Error::is()) ? ["ЕстьОшибка" => true, "ТекстОшибки" => $this->errors()] : $result->getJsonResult();
    }

    public function getListByUid($uid)
    {
        $result = $this->auth("Site_Exchange", "dS-89eoeX_")->get("https://1c.pobeda-corp.com:4433/uf_static_test/hs/API/PartnerAgreements?UID=" . $uid . "&type_of_contract=Залог&status=");

        return (Error::is()) ? false : $result->getJsonResult();
    }

    public function getContractHistory($contractUID)
    {
        $result = $this->auth("Site_Exchange", "dS-89eoeX_")->get("https://1c.pobeda-corp.com:4433/uf_static_test/hs/API/PartnerAgreementHistory?UID=" . $contractUID);

        return (Error::is()) ? ["ЕстьОшибка" => true, "ТекстОшибки" => $this->errors()] : $result->getJsonResult();
    }

    public function getProlongationSumm($params)
    {
        $result = $this->auth("WEBService", "dS-89eoeX_")->get("https://1c.pobeda-corp.com:5446/uf_product_test_services/hs/Prolongation/GetProlongationSum?date=" . $params["date"] . "&number=" . $params["number"] ."&date_of_calc=" . $params["date_of_calc"] . "&UID=" . $params["UID"]);

        return (Error::is()) ? ["ЕстьОшибка" => true, "ТекстОшибки" => $this->errors()] : $result->getJsonResult();
    }

    public function prolongateContract($params)
    {
        $result = $this->auth("WEBService", "dS-89eoeX_")->post("https://1c.pobeda-corp.com:5446/uf_product_test_services/hs/Prolongation/AgreementProlongation?UID=" .$params["UID"] ."&date=" . $params["date"] . "&date_of_calc=" . $params["date_of_calc"] . "&number=" . $params["number"] . "&check_number_KKM=" . $params["check_number_KKM"] . "&ogrn_number=" . $params["ogrn_number"] . "&prolongation_sum=" . $params["prolongation_sum"]);

        return (Error::is()) ? ["ЕстьОшибка" => true, "ТекстОшибки" => $this->errors()] : $result->getJsonResult();
    }

    private function errors()
    {
        $messages = [];

        foreach(Error::list() as $message)
        {
            $arr = json_decode($message, true);

            if(is_array($arr))
            {
                if(count($arr) > 0)
                {
                    array_push($messages, $arr["ТекстОшибки"]);
                }
            }
            else
            {
                array_push($messages, $message);
            }
        }

        return implode($messages);
    }
}