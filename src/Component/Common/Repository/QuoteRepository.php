<?php

namespace App\Component\Common\Repository;

use App\Component\Common\Entity\QuoteEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<QuoteEntity>
 * @method QuoteEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuoteEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuoteEntity[]    findAll()
 * @method QuoteEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuoteEntity::class);
    }
}
