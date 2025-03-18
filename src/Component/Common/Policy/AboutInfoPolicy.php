<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\AboutEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class AboutInfoPolicy
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
        return $this->entityManager->getRepository(AboutEntity::class)->findAll();
    }
}
