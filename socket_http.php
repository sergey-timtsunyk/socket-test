#!/usr/bin/env php
<?php

require_once 'autoload.php';

$options = getopt('i:p:');

$socket = stream_socket_server("tcp://{$options['i']}:{$options['p']}", $errno, $errstr);

$dataArray = [];

if (!$socket) {
    die("$errstr ($errno)\n");
}

while ($connect = stream_socket_accept($socket, -1)) {

    $requestString = fread($connect, 1024);

    $parser = new \Socket\Processing\ParserStringToRequest($requestString);
    $request = $parser->getRequest();
    $response = new \Socket\Processing\Response();
    $response->setCode(200);
    $response->setStatusMessage('OK');
    $response->addHeader('Connection', 'close');


    if (!$cookie = $request->getCookie('SOCKETID')) {
        $cookie = hash_hmac('ripemd160', date('now'), 'secret');

        $response->addCookie('SOCKETID', $cookie);

        $dataArray[$cookie] = [];
    }

    $queryArray = $request->getQuery();
    $queryKey = array_shift($queryArray);

    switch ($request->getMethod()) {
        case 'POST' : $dataArray[$cookie][$queryKey] = '';  break;
        case 'GET' : {
            if (array_key_exists($queryKey, $dataArray[$cookie])) {
                $response->setBody($dataArray[$cookie][$queryKey]);
            }
            break;
        }
        case 'DELETE' : {
            if (array_key_exists($queryKey, $dataArray[$cookie])) {
                unset($dataArray[$cookie][$queryKey]);
            }
            break;
        }
        default: {
            $response->setCode(405);
            $response->setStatusMessage('Method Not Allowed');
        }
    }

    $processingResponse = new \Socket\Processing\ProcessingResponse($response);

    fwrite($connect, $processingResponse->getResponse());
    fclose($connect);
}

fclose($socket);
