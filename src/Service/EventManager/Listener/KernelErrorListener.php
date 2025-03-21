<?php

declare(strict_types=1);

namespace App\Service\EventManager\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

#[AsEventListener(event: ExceptionEvent::class, method: 'onKernelException')]
class KernelErrorListener
{
    public function __construct(
        private LoggerInterface $logger
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();
        $code = $throwable instanceof HttpExceptionInterface ? $throwable->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;

        $params = [
            'error' => true,
            'message' => $throwable->getMessage(),
            'request' => $event->getRequest()->getContent(false),
        ];
        if (!isset($_ENV['APP_ENV']) || $_ENV['APP_ENV'] !== 'prod') {
            $params['error_code'] = $code;
            $params['error_trace'] = $throwable->getTrace();
        }

        $this->logger->warning('onKernelException', $params);

        $response = new Response($throwable->getMessage(), Response::HTTP_OK);

        $event->allowCustomResponseCode();
        $event->setResponse($response);
    }
}
