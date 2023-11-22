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

        if($this->session->paymentId && $info && $payment->isPaymentSuccess())
        {
            //получаем информацио о договоре
            $gate = new Gate();
            $data = $gate->getContractHistory($payment->getPaymentProduct());

            if($data)
            {
                $today = new \DateTime("now");
                $dateOfCalc = $today->format("d.m.Y H:i:s");

                $params = [
                    "UID" => $data["УИД"],
                    "date" => $data["Дата"],
                    "date_of_calc" => $dateOfCalc,
                    "number" => $data["Номер"],
                    "check_number_KKM" => 4444,
                    "ogrn_number" => 999,
                    "prolongation_sum" => $payment->getPaymentAmount()
                ];

                $result = $gate->prolongateContract($params);
                $this->session->remove("paymentId");

                if($result["ЕстьОшибка"])
                {
                    return $this->render("statuses/success.php", ["title" => "Ошибка пролонгирования договора!", "text" => "Платеж завершен успешно, однако договор " . $data["Номер"] . " не продлен по причине ошибки: '" . $result["ТекстОшибки"] . "'. Свяжитесь с нами для решения этой проблемы."]);
                }
                else
                {
                    return $this->render("statuses/success.php", ["title" => "Платеж успешно принят!", "text" => "Ваш платеж успешна завершен. Договор номер " . $data["Номер"] . " продлен."]);
                }
            }

            return $this->render("statuses/success.php", ["title" => "Информация о договоре не найдена!", "text" => "Информация о договоре номер " . $data["Номер"] . " не найдена в нашей базе данных. Свяжитесь с нами для решения этой проблемы."]);
        }
        else
        {
            return $this->render("statuses/success.php", ["title" => "Платеж пока не принят!", "text" => "Платеж зарегистриован платежной системой, однако пока не завершился успешно. Мы следим за ситуацией и известим Вас, когда платеж будет завершен."]);
        }
    }

    public function error()
    {
        return $this->render("statuses/error.php", ["title" => "Платеж не принят!", "text" => "Во время проведения платежа возникла ошибка, транзакция не выполнена. Вернитесь в личный кабинет и попробуйте провести платеж позже"]);
    }
}