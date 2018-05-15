<?php
namespace Socket\Processing;

class Request implements RequestInterface
{
    private $query = [];
    private $method;
    private $cookies;
    private $body;

    public function getQuery(): array
    {
        return $this->query;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getCookie($key): string
    {
        return array_key_exists($key, $this->cookies) ? $this->cookies[$key] : '';
    }

    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param mixed $query
     */
    public function setQuery($query): void
    {
        $this->query = $query;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }

    /**
     * @param array $cookies
     */
    public function setCookies(array $cookies): void
    {
        $this->cookies = $cookies;
    }
}
