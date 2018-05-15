<?php
namespace Socket\Processing;

interface RequestInterface
{
    public function getQuery(): array;

    public function getMethod(): string;

    public function getCookie($key): string;

    public function getBody(): string;
}
