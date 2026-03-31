<?php

declare(strict_types=1);

namespace App\Component\Common\Controller;

use App\Component\Common\Policy\AboutInfoPolicy;
use App\Component\Common\Policy\ContactsPolicy;
use App\Component\Common\Policy\PlayersPolicy;
use App\Component\Common\Policy\QuotesListPolicy;
use App\Component\Common\ValueObject\ErrorJsonResponse;
use App\Component\Common\ValueObject\SetPlayerRequest;
use App\Service\Component\Controller\AbstractApiController;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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

    public function getRatingAction(Request $request, PlayersPolicy $policy): JsonResponse
    {
        try {
            $token = $request->headers->get('X-Fingerprint');

            return new JsonResponse([
                'errorCode' => 0,
                'data' => $policy->getList($token),
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }

    public function getPlayerAction(Request $request, PlayersPolicy $policy): JsonResponse
    {
        try {
            $token = $request->headers->get('X-Fingerprint');
            if ($token === null) {
                return new JsonResponse([
                    'errorCode' => 0,
                    'data' => null,
                ]);
            }

            $player = $policy->getByToken($token);
            if ($player === null) {
                return new JsonResponse([
                    'errorCode' => 0,
                    'data' => null,
                ]);
            }

            $data = $player->jsonSerialize();
            $data['is_current'] = true;

            return new JsonResponse([
                'errorCode' => 0,
                'data' => $data,
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                throwable: $throwable
            );
        }
    }

    public function setPlayerAction(#[MapRequestPayload] SetPlayerRequest $request, PlayersPolicy $policy): JsonResponse
    {
        try {
            $player = $policy->save($request);

            return new JsonResponse([
                'errorCode' => 0,
                'data' => $player,
            ]);
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage());

            return new ErrorJsonResponse(
                error: $throwable->getMessage(),
                code: 400,
                throwable: $throwable,
                message: $this->getCode($throwable)
            );
        }
    }

    private function getCode(\Throwable $throwable): string
    {
        return match (get_class($throwable)) {
            UniqueConstraintViolationException::class => 'UNIQUE',
            default => 'OTHER',
        };
    }
}
