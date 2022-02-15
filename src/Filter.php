<?php

namespace RusavskiyAV\RequestLogBundle;

class Filter
{
    private string $ip;

    public function __construct()
    {
        $this->ip = '';
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function withIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }
}
