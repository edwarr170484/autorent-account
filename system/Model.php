<?php 
namespace Webwarrd\Core;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\TransferException;
use Webwarrd\Core\Application;
use Webwarrd\Core\Error;

class Model
{
    public $config;
    public $session;
    private $client;
    private $params;
    private $result;
    protected $request;
    
    
    public function __construct()
    {
        $this->request = Application::$request;
        $this->config = Application::$config;
        $this->session = Application::$session;
        $this->client = new Client();
        
        $this->params = [
            'verify' => false
        ];

        $this->result = [];
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
            $this->handleError($e);
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
            $this->handleError($e);
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
            $this->handleError($e);
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

    protected function getStatusCode(){
        return $this->result->getStatusCode();
    }

    private function handleError($exception)
    {
        if ($exception->hasResponse()) 
        {
            Error::add($exception->getResponse()->getBody());
        } 
        else 
        {
            Error::add($exception->getMessage());
        }
    }
}