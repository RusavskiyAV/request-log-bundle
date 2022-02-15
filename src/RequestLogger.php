<?php

declare(strict_types=1);

namespace RusavskiyAV\RequestLogBundle;

use RusavskiyAV\RequestLogBundle\Iterator\FilterIterator;
use RusavskiyAV\RequestLogBundle\Iterator\ToRequestLogIterator;

class RequestLogger implements RequestLoggerInterface
{
    private string $log_file;

    public function __construct(string $log_file)
    {
        $this->log_file = $log_file;
    }

    /**
     * {@inheritDoc}
     */
    public function log(RequestLog $requestLog): void
    {
        $file = new \SplFileObject($this->log_file, 'a');

        if (!$file->flock(LOCK_EX)) {
            throw new \RuntimeException('Не удалось получить блокировку');
        }

        $file->fputcsv([
            $requestLog->getUrl(),
            $requestLog->getRequest(),
            $requestLog->getResponse(),
            $requestLog->getStatus(),
            $requestLog->getIp(),
            $requestLog->getDateTime()->format(DATE_ATOM)
        ]);
        $file->flock(LOCK_UN);
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll(Filter $filter): iterable
    {
        if (!file_exists($this->log_file)) {
            return [];
        }

        $file = new \SplFileObject($this->log_file);
        $file->setFlags(\SplFileObject::READ_CSV | \SplFileObject::SKIP_EMPTY | \SplFileObject::READ_AHEAD);

        if (!$file->flock(LOCK_SH)) {
            throw new \RuntimeException('Не удалось получить блокировку');
        }

        return new FilterIterator(new ToRequestLogIterator($file), $filter);
    }
}
