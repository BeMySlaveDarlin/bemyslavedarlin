<?php

declare(strict_types=1);

namespace App\Component\Common\Controller;

use App\Component\Common\Policy\AboutInfoPolicy;
use App\Component\Common\Policy\ContactsPolicy;
use App\Component\Common\Policy\QuotesListPolicy;
use App\Component\Common\Policy\RatingPolicy;
use App\Component\Common\ValueObject\ErrorJsonResponse;
use App\Service\Component\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

class ApiController extends AbstractApiController
{
    public function getQuotesAction(QuotesListPolicy $policy): JsonResponse
    {
        try {
            return new JsonResponse([
                'errorCode' => 0,
                'data' => $policy->getList(),
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }

    public function getContactsAction(ContactsPolicy $policy): JsonResponse
    {
        try {
            return new JsonResponse([
                'errorCode' => 0,
                'data' => $policy->getList(),
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }

    public function getAboutAction(AboutInfoPolicy $policy): JsonResponse
    {
        try {
            return new JsonResponse([
                'errorCode' => 0,
                'data' => $policy->getList(),
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }

    public function getRatingAction(RatingPolicy $policy): JsonResponse
    {
        try {
            return new JsonResponse([
                'errorCode' => 0,
                'data' => $policy->getList(),
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }
}
