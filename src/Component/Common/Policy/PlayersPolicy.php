<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\PlayerEntity;
use App\Component\Common\ValueObject\SetPlayerRequest;
use App\Service\Doctrine\Type\JsonBValue;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Throwable;

readonly class PlayersPolicy
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {
    }

    /**
     * @return array<array<string, mixed>>
     */
    public function getList(?string $currentToken = null): array
    {
        $players = $this->entityManager->getRepository(PlayerEntity::class)->findTopTen();
        $result = [];
        foreach ($players as $player) {
            $data = $player->jsonSerialize();
            if ($currentToken !== null && $player->token === $currentToken) {
                $data['is_current'] = true;
            }
            $result[] = $data;
        }

        return $result;
    }

    public function getByToken(string $token): ?PlayerEntity
    {
        return $this->entityManager->getRepository(PlayerEntity::class)->findOneBy(['token' => $token]);
    }

    public function save(SetPlayerRequest $request): PlayerEntity
    {
        try {
            $player = $this->entityManager->getRepository(PlayerEntity::class)->findOneBy(['token' => $request->fingerprint]);
            if (null === $player) {
                $player = new PlayerEntity();
                $player->token = $request->fingerprint;
            }

            $nickname = $request->nick !== null ? trim(strip_tags($request->nick)) : null;
            if ($nickname !== null && mb_strlen($nickname) < 3) {
                $nickname = null;
            }
            $player->nickname = $nickname;
            $player->grade = $request->grade;
            $player->money = (string)$request->money;
            $player->skills = new JsonBValue($request->skills ?? []);

            $this->entityManager->persist($player);
            $this->entityManager->flush();

            return $player;
        } catch (Throwable $throwable) {
            $this->logger->error($throwable->getMessage(), [
                'request' => $request,
            ]);

            throw $throwable;
        }
    }
}
