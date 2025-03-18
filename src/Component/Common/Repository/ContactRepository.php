<?php

namespace App\Component\Common\Repository;

use App\Component\Common\Entity\ContactEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactEntity>
 * @method ContactEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactEntity[]    findAll()
 * @method ContactEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactEntity::class);
    }
}
