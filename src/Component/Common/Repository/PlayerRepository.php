<?php

namespace App\Component\Common\Repository;

use App\Component\Common\Entity\PlayerEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PlayerEntity>
 * @method PlayerEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlayerEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlayerEntity[]    findAll()
 * @method PlayerEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlayerEntity::class);
    }

    public function findTopTen(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy()
            ->orderBy('p.money', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
