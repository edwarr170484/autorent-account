<?php
namespace App\Account\Controller;

use Webwarrd\Core\Controller;
use App\Account\Model\Gate;

class MainController extends Controller
{
    public function index()
    {
        $gate = new Gate();
        $items = [];
        $statuses = ["Активен", "Идет просрочка", "Просрочен"];

        $list = $gate->getListByUid($this->session->uid["Партнер_УИД"]);

        if($list && count($list["Договора"]) > 0)
        {
            foreach($list["Договора"] as $contract)
            {
                $class = (in_array($contract["СтатусПодробно"], $statuses)) ? "active" : "";

                $items[] = [
                    "УИД" => $contract["УИД"],
                    "Номер" => $contract["Номер"],
                    "Дата" => $contract["Дата"],
                    "СтатусПодробно" => $contract["СтатусПодробно"],
                    "ДатаПоследнегоПродления" => $contract["ДатаПоследнегоПродления"],
                    "СуммаПролонгации" => $contract["СуммаПролонгации"],
                    "СуммаЗакрытия" => $contract["СуммаЗакрытия"],
                    "Класс" => "all " . $class,
                    "Номенклатура" => $contract["Номенклатура"]
                ];
            }

            usort($items, function ($a, $b){
                return strtotime($b["Дата"]) - strtotime($a["Дата"]);
            });
        }
        
        return $this->render("index.php", ["items" => $items, "text" => "Данных пока нет"]);
    }

    public function history()
    {
        $gate = new Gate();

        $data = $gate->getContractHistory($this->request->get("UID"));
        
        return $this->render("history.php", ["data" => $data]);
    }

    public function summ()
    {
        $gate = new Gate();
        
        $today = new \DateTime("now");

        $params = [
            "date" => $this->request->post("contractStart"),
            "number" => $this->request->post("contractNumber"),
            "date_of_calc" => $today->format("d.m.Y H:i:s"),
            "UID" => $this->request->post("contractUid")
        ];

        $summ = $gate->getProlongationSumm($params);

        return $this->json(["summ" => ($summ && !$summ["ЕстьОшибка"]) ? $summ["СуммаПролонгации"] : "Недоступно"]);
    }

    private function getContractData($uid)
    {
        $gate = new Gate();

        $data = $gate->getContractHistory($uid);

        return $data;
    }
}