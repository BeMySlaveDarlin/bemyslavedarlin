<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\AboutEntity;
use App\Component\Common\Entity\PlayerEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class RatingPolicy
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return AboutEntity[]
     */
    public function getList(): array
    {
        return $this->entityManager->getRepository(PlayerEntity::class)->findTopTen();
    }
}
