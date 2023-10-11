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

        if($contract)
        {
            $payment = "App\\Account\\Model\\" . $contract["payment"];
            $gate = new $payment();

            return $this->json($gate->createPayment($contract["uid"], $contract["sum"]));
        }
    }

    public function success()
    {
        $gate = new Gate();

        $gate->prolongateContract();

        return $this->renderRaw("Success");
    }

    public function error()
    {
        return $this->renderRaw("Error");
    }
}