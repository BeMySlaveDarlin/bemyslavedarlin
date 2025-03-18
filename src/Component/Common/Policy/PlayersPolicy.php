<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\AboutEntity;
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
     * @return AboutEntity[]
     */
    public function getList(): array
    {
        return $this->entityManager->getRepository(PlayerEntity::class)->findTopTen();
    }

    public function save(SetPlayerRequest $request): PlayerEntity
    {
        try {
            $player = $this->entityManager->getRepository(PlayerEntity::class)->findOneBy(['token' => $request->fingerprint]);
            if (null === $player) {
                $player = new PlayerEntity();
                $player->token = $request->fingerprint;
            }

            $player->nickname = $request->nick;
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
