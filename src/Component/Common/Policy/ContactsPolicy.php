<?php

declare(strict_types=1);

namespace App\Component\Common\Policy;

use App\Component\Common\Entity\ContactEntity;
use Doctrine\ORM\EntityManagerInterface;

readonly class ContactsPolicy
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return ContactEntity[]
     */
    public function getList(): array
    {
        return $this->entityManager->getRepository(ContactEntity::class)->findAll();
    }
}
