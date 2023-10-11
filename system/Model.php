<?php 
namespace Webwarrd\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\TransferException;
use Webwarrd\Core\Application;

class Model
{
    public $config;
    private $client;
    private $params;
    private $result;
    private $errors;
    protected $request;
    
    
    public function __construct()
    {
        $this->request = Application::$request;
        $this->config = Application::$config;
        $this->client = new Client();
        
        $this->params = [
            'verify' => false
        ];

        $this->result = [];
        $this->errors = [];
    }

    protected function auth($login, $password)
    {
        $this->params['auth'] = [$login, $password];

        return $this;
    }

    protected function get($url)
    {
        try 
        {
            $this->result =  $this->client->get($url, $this->params);
        }
        catch(TransferException $e)
        {
            $this->addError($e->getResponse()->getBody(true));
        }

        return $this;
    }

    protected function post($url, $params = [])
    {
        $this->params["form_params"] = $params;

        try
        {
            $this->result = $this->client->post($url, $this->params);
        }
        catch(TransferException $e)
        {
            $this->addError($e->getResponse()->getBody(true));
        }

        return $this;
    }

    protected function post_json($url, $params = [])
    {
        $this->params["json"] = $params;

        try
        {
            $this->result = $this->client->post($url, $this->params);
        }
        catch(TransferException $e)
        {
            $this->addError($e->getResponse()->getBody(true));
        }

        return $this;
    }

    protected function getResult()
    {
        return $this->result->getBody();
    }

    protected function getJsonResult()
    {
        return json_decode($this->result->getBody(), true);
    }

    protected function isErrors()
    {
        return count($this->errors) > 0 ? true : false;
    }

    protected function addError($message)
    {
        array_push($this->errors, $message);
    }

    protected function getErrors()
    {
        return ["error" => 1, "messages" => $this->errors];
    }

    protected function getStatusCode(){
        return $this->result->getStatusCode();
    }
}