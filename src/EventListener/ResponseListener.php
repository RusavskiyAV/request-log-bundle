<?php

declare(strict_types=1);

namespace RusavskiyAV\RequestLogBundle\EventListener;

use Psr\Log\LoggerInterface;
use RusavskiyAV\RequestLogBundle\RequestLog;
use RusavskiyAV\RequestLogBundle\RequestLoggerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ResponseListener
{
    private RequestLoggerInterface $requestLogger;
    private LoggerInterface $logger;

    public function __construct(RequestLoggerInterface $requestLogger, LoggerInterface $logger)
    {
        $this->requestLogger = $requestLogger;
        $this->logger = $logger;
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->query->has('request-log')) {
            return;
        }

        $response = $event->getResponse();

        try {
            $this->requestLogger->log(
                new RequestLog(
                    $request->getUri(),
                    "{$request->headers}\r\n\r\n{$request->getContent()}",
                    "{$response->headers}\r\n\r\n{$response->getContent()}",
                    $response->getStatusCode(),
                    (string) $request->getClientIp(),
                    new \DateTimeImmutable('now', new \DateTimeZone('UTC'))
                )
            );
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), ['Trace' => $exception->getTrace()]);
        }
    }
}
