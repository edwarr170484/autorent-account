<?php
namespace App\Account\Controller;

use Webwarrd\Core\Controller;
use App\Account\Model\BestPay;
use App\Account\Model\Wirebank;

use App\Account\Model\Gate;

class PaymentController extends Controller
{
    public function create()
    {
        $contract = $this->request->post("contract");
        $this->session->payment = $contract["payment"];

        if($contract)
        {
            $payment = "App\\Account\\Model\\" . $contract["payment"];
            $gate = new $payment();

            return $this->json($gate->createPayment($contract["uid"], $contract["sum"]));
        }
    }

    public function success()
    {
        //получаем информацию о платеже
        $paymentMethod = "App\\Account\\Model\\" . $this->session->payment;
        $payment = new $paymentMethod();
        $info = $payment->getPaymentInformation();

        if($payment->isPaymentSuccess())
        {
            //получаем информацио о договоре
            $gate = new Gate();
            $data = $gate->getContractHistory($payment->reference);

            if($data)
            {
                $startDateParts = explode(" ", $data["Дата"]);
                $today = new \DateTime("now");
                $dateOfCalc = $today->format("d.m.Y") . " " . $startDateParts[1];

                $params = [
                    "UID" => $data["УИД"],
                    "date" => $data["Дата"],
                    "date_of_calc" => $dateOfCalc,
                    "number" => $data["Номер"],
                    "check_number_KKM" => 4444,
                    "ogrn_number" => 999,
                    "prolongation_sum" => (float)$payment->amount / 100
                ];

                $result = $gate->prolongateContract($params);
            }

            return $this->render("statuses/success.php", ["title" => "Платеж успешно принят!", "text" => "Ваш платеж успешна завершен. Договор номер " . $data["Номер"] . " продлен."]);
        }
        else
        {
            return $this->render("statuses/success.php", ["title" => "Платеж пока не принят!", "text" => "Платеж зарегистриован платежной системой, однако пока не завершился успешно. Мы следим за ситуацией и известим Вас, когда платеж будет завершен."]);
        }
    }

    public function error()
    {
        return $this->render("statuses/error.php", []);
    }
}