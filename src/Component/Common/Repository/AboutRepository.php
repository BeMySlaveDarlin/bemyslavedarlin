<?php

namespace App\Component\Common\Repository;

use App\Component\Common\Entity\AboutEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AboutEntity>
 * @method AboutEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AboutEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AboutEntity[]    findAll()
 * @method AboutEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AboutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AboutEntity::class);
    }
}
