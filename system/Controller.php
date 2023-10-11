<?php 
namespace Webwarrd\Core;

use Webwarrd\Core\Application;

class Controller
{
    protected $request;
    protected $session;
    protected $router;
    protected $config;

    public function __construct($router)
    {
        $this->request = Application::$request;
        $this->session = Application::$session;
        $this->router = $router;
        $this->config = Application::$config;
    }

    public function render($view, $params)
    {
        ob_start();
        
        if(count($params) > 0)
        {
            foreach($params as $k => $v) {
                $$k = $v;
            }
        }
        
        include(Application::$rootDir . "/src/View/" . $view);

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public function renderRaw($data)
    {
        return $data;
    }

    public function json($data)
    {
        Application::$response->addHeader('Content-Type: application/json');

        $content = json_encode($data);

        return $content;
    }

    public function redirectToRoute($name)
    {
        $this->router->redirect($name);
    }
}