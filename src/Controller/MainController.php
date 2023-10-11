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

        $list = $gate->getListByUid($this->session->uid["Партнер_УИД"]);

        if($list && count($list["Договора"]) > 0)
        {
            foreach($list["Договора"] as $item)
            {
                $startDateParts = explode(" ", $item["Дата"]);
                $today = new \DateTime("now");

                $prolongationDate = $today->format("d.m.Y") . " " . $startDateParts[1];
                $summ = $gate->getProlongationSumm($item["УИД"], $item["Номер"], $item["Дата"], $prolongationDate);

                $items[] = [
                    "УИД" => $item["УИД"],
                    "Номер" => $item["Номер"],
                    "Дата" => $item["Дата"],
                    "СтатусПодробно" => $item["СтатусПодробно"],
                    "ДатаВыкупа" => $item["ДатаВыкупа"],
                    "СуммаПролонгации" => $item["СуммаПролонгации"],
                    "АктуальнаяСумма" => ($summ && !$summ["ЕстьОшибка"]) ? $summ["СуммаПролонгации"] : "Недоступно"
                ];
            }
        }
        
        return $this->render("index.php", ["items" => $items, "text" => "Данных пока нет"]);
    }

    public function history()
    {
        $gate = new Gate();

        $data = $gate->getContractHistory($this->request->get("UID"));
        
        return $this->render("history.php", ["data" => $data]);
    }
}