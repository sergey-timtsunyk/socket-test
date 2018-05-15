<?php
/**
 * User: Serhii T.
 * Date: 5/15/18
 */

namespace Socket\Processing;

class ProcessingResponse
{
    const DETERMINATE = "\r\n";

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function getResponse()
    {
        $headerStr = $this->createHeadersStr($this->response->getHeaders());
        $cookiesStr = $this->createCookiesStr($this->response->getCookies());

        return sprintf(
            "HTTP/1.1 %s %s%s%s%s%s%s%s",
            $this->response->getCode(),
            $this->response->getStatusMessage(),
            self::DETERMINATE,
            $headerStr,
            $cookiesStr,
            self::DETERMINATE,
            self::DETERMINATE,
            $this->response->getBody()
        );
    }

    private function createHeadersStr($headers)
    {
        $str = '';
        foreach ($headers as $key => $val) {
            $str .= sprintf("%s: %s%s", $key, $val, self::DETERMINATE);
        }

        return $str;
    }

    private function createCookiesStr($cookies = [])
    {
        $cookiesStr = '';
        foreach ($cookies as $key => $val) {
            $cookiesStr .= sprintf("Set-Cookie: %s=%s%s", $key, $val, self::DETERMINATE);
        }

        return $cookiesStr;
    }
}
