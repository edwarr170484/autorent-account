<?php
namespace App\Account\Controller;

use Webwarrd\Core\Controller;
use Webwarrd\Core\Application;
use Webwarrd\Core\Security;
use App\Account\Model\Sms;
use App\Account\Model\Gate;

class SecurityController extends Controller
{
    public function index()
    {
        if(Security::checkAuth())
        {
            $this->redirectToRoute("main");
        }

        return $this->render("login/login.php", ["message" => null]);
    }

    public function sms()
    {
        if($this->request->getMethod() == "post" && $this->request->post("phone"))
        {
            $gate = new Gate();

            $uid = $gate->getUidByPhone($this->request->post("phone"));

            if($uid && !$uid["ЕстьОшибка"])
            {
                $this->session->uid = $uid;
                $this->session->phone = $this->request->post("phone");
                $this->session->code = 1704;//rand(1000, 9999);

                $sms = new Sms();
                
                $smsResult = $sms->send($this->request->post("phone"), "Authorithation code: " . $this->session->code);

                if(!$smsResult["error"])
                {
                    return $this->render("login/code.php", ["phone" => $this->request->post("phone"), "message" => $smsResult["message"]]);
                }
                else
                {
                    return $this->render("login/error.php", ["phone" => $this->request->post("phone"), "message" => $smsResult["message"]]);
                }
            }
            else
            {
                return $this->render("login/error.php", ["phone" => $this->request->post("phone"), "message" => $uid["ТекстОшибки"]]);
            }
        }
        else
        {
            $this->redirectToRoute("login");
        }
    }

    public function auth()
    {
        if($this->request->getMethod() == "post" && $this->request->post("phone"))
        {
            if(Security::auth())
            {
                return $this->json(["error" => 0]);
            }
            else
            {
                return $this->json(["error" => 1, "message" => "Неверные данные авторизации"]);
            }
        }
        else
        {
            $this->redirectToRoute("login");
        }
    }

    public function logout()
    {
        $this->session->remove("phone");
        $this->session->remove("code");
        $this->session->remove("userId");

        $this->redirectToRoute("login");
    }
}