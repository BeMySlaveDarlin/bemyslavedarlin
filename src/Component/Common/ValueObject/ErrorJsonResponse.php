<?php

declare(strict_types=1);

namespace App\Component\Common\ValueObject;

use App\Service\Doctrine\Exception\RecordAlreadyExistsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class ErrorJsonResponse extends JsonResponse
{
    public function __construct(
        string $error = '',
        int $code = 500,
        Throwable $throwable = null
    ) {
        $code = $this->getThrowableCode($code, $throwable);

        parent::__construct([
            'errorCode' => $code,
            'errorDescription' => $error,
            'data' => null,
        ], $code);
    }

    private function getThrowableCode(int $code, ?Throwable $throwable = null): int
    {
        return match (true) {
            $throwable instanceof HttpException => $throwable->getStatusCode(),
            $throwable instanceof BadRequestHttpException => 400,
            $throwable instanceof UnauthorizedHttpException => 401,
            $throwable instanceof AccessDeniedHttpException => 403,
            $throwable instanceof NotFoundHttpException => 404,
            $throwable instanceof ConflictHttpException, $throwable instanceof RecordAlreadyExistsException => 409,
            default => $code,
        };
    }
}
