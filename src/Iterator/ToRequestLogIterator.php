<?php

declare(strict_types=1);

namespace RusavskiyAV\RequestLogBundle\Iterator;

use RusavskiyAV\RequestLogBundle\RequestLog;

class ToRequestLogIterator extends \IteratorIterator
{
    public function current(): RequestLog
    {
        $row = parent::current();

        return new RequestLog(
            $row[0],
            $row[1],
            $row[2],
            (int) $row[3],
            $row[4],
            new \DateTimeImmutable($row[5], new \DateTimeZone('UTC'))
        );
    }
}
