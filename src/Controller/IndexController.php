<?php

declare(strict_types=1);

namespace RusavskiyAV\RequestLogBundle\Controller;

use Psr\Log\LoggerInterface;
use RusavskiyAV\RequestLogBundle\Filter;
use RusavskiyAV\RequestLogBundle\RequestLoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    private RequestLoggerInterface $requestLogger;
    private LoggerInterface $logger;
    private string $timezone;

    public function __construct(RequestLoggerInterface $requestLogger, LoggerInterface $logger, string $timezone)
    {
        $this->requestLogger = $requestLogger;
        $this->logger = $logger;
        $this->timezone = $timezone;
    }

    public function index(Request $request): Response
    {
        $filter = $request->query->has('ip')
            ? (new Filter())->withIp($request->query->get('ip'))
            : new Filter();

        try {
            $logs = $this->requestLogger->fetchAll($filter);
        } catch (\Exception $exception) {
            $this->logger->critical($exception->getMessage(), ['Trace' => $exception->getTrace()]);

            return new Response('Не удалось загрузить логи');
        }

        return $this->render('@RusavskiyAVRequestLog/index.html.twig', [
            'logs' => $logs,
            'timezone' => $this->timezone,
        ]);
    }
}
