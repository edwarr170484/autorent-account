<?php
namespace Webwarrd\Core;

class Response
{
    private $body;

    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function addHeader($header)
    {
        header($header);
    }

    public function send($body = null)
    {
        if($body)
        {
            $this->setBody($body);
        }

        echo $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }
}