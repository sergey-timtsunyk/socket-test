<?php

$options = getopt('i:p:');

$fp = stream_socket_client("tcp://{$options['i']}:{$options['p']}", $errno, $errstr, 30);
if (!$fp) {
    echo "$errstr ($errno)<br />\n";
} else {
    fwrite($fp, "GET / HTTP/1.0\r\nHost: www.example.com\r\nAccept: */*\r\n\r\n");
    while (!feof($fp)) {
        echo fgets($fp, 1024);
    }

    fclose($fp);
}