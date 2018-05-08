#!/usr/bin/env php
<?php

$options = getopt('i:p:');

$socket = stream_socket_server("tcp://{$options['i']}:{$options['p']}", $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)\n");
}

while ($connect = stream_socket_accept($socket, -1)) {

    echo fread($connect, 1024);
    fwrite($connect, "HTTP/1.1 200 OK\r\nContent-Type: text/html\r\nConnection: close\r\n\r\nHi!!!");
    fclose($connect);
}

fclose($socket);
