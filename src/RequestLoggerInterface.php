<?php

namespace RusavskiyAV\RequestLogBundle;

interface RequestLoggerInterface
{
    /**
     * @throws \Exception
     */
    public function log(RequestLog $requestLog): void;

    /**
     * @throws \Exception
     */
    public function fetchAll(Filter $filter): iterable;
}
