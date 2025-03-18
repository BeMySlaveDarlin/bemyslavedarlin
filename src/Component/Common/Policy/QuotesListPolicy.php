<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\QuoteEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class QuotesListPolicy
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return QuoteEntity[]
     */
    public function getList(): array
    {
        return $this->entityManager->getRepository(QuoteEntity::class)->findAll();
    }
}
