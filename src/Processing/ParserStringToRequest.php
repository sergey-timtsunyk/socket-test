<?php
/**
 * User: Serhii T.
 * Date: 5/11/18
 */

namespace Socket\Processing;

class ParserStringToRequest
{
    /**
     * @var Request
     */
    private $request;

    public function __construct($string)
    {
        $this->request = new Request();
        $this->parser($string);
    }

    /**
     * @return RequestInterface
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    private function parser($string)
    {
        $array = explode(PHP_EOL, $string);

        $firstLine = array_shift($array);
        $this->request->setMethod(
            $this->getMethod($firstLine)
        );
        $this->request->setQuery(
            $this->getQuery($firstLine)
        );
        $this->request->setBody(array_pop($array));

        $this->request->setCookies(
            $this->parserByCookies($array)
        );
    }

    private function getMethod($firstLine)
    {
        $array = explode(' ', $firstLine);

        return array_shift($array);
    }

    private function getQuery($firstLine)
    {
        $pos = strpos($firstLine, '?');
        $firstLine = substr($firstLine, $pos + 1);
        $array = explode(' ', $firstLine);
        $firstLine = current($array);

        parse_str($firstLine, $arr);

        return is_array($arr) ? $arr: [];
    }

    private function parserByCookies($array)
    {
        $cookieArray = [];
        foreach ($array as $value) {
            if ($cookie = strstr($value, 'Cookie:')) {
                $cookiesStrArray = explode(';', str_replace('Cookie:', '',$cookie));

                foreach ($cookiesStrArray as $cookie) {
                    $arr = explode('=', trim($cookie));
                    $cookieArray[current($arr)] = next($arr);
                }
            }
        }

        return $cookieArray;
    }
}
