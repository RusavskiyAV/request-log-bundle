<?php

namespace RusavskiyAV\RequestLogBundle;

class RequestLog
{
    private string $url;
    private string $request;
    private string $response;
    private int $status;
    private string $ip;
    private \DateTimeImmutable $dateTime;

    public function __construct(
        string $url,
        string $request,
        string $response,
        int $status,
        string $ip,
        \DateTimeImmutable $dateTime
    ) {
        $this->url = $url;
        $this->request = $request;
        $this->response = $response;
        $this->status = $status;
        $this->ip = $ip;
        $this->dateTime = $dateTime;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getRequest(): string
    {
        return $this->request;
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getDateTime(): \DateTimeImmutable
    {
        return $this->dateTime;
    }
}
