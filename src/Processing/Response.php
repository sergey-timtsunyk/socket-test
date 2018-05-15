<?php
/**
 * User: Serhii T.
 * Date: 5/15/18
 */

namespace Socket\Processing;

class Response implements ResponseInterface
{
    private $body;
    private $code;
    private $statusMessage;
    private $headers = [];
    private $cookies = [];

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
    }

    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    public function addCookie($key, $value)
    {
        $this->cookies[$key] = $value;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getCookies()
    {
        return $this->cookies;
    }

    public function getBody()
    {
        return $this->body;
    }
}
