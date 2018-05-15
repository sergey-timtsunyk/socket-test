<?php
/**
 * User: Serhii T.
 * Date: 5/15/18
 */

namespace Socket\Processing;

interface ResponseInterface
{
    public function setCode($code);
    public function setStatusMessage($message);
    public function addHeader($key, $value);
    public function addCookie($key, $value);
    public function setBody($body);

    public function getCode();
    public function getStatusMessage();
    public function getHeaders();
    public function getCookies();
    public function getBody();
}

