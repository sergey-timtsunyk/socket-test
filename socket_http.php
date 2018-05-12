#!/usr/bin/env php
<?php

require_once 'autoload.php';

$options = getopt('i:p:');

$socket = stream_socket_server("tcp://{$options['i']}:{$options['p']}", $errno, $errstr);


if (!$socket) {
    die("$errstr ($errno)\n");
}

while ($connect = stream_socket_accept($socket, -1)) {

    $requestString = fread($connect, 1024);

    $parser = new \Socket\Processing\ParserStringToRequest($requestString);

    $request = $parser->getRequest();

    var_dump($request);

    fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nHi!!!");
    fclose($connect);
}

fclose($socket);
