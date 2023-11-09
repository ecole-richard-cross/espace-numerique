<?php

namespace App\Repository;

use App\Entity\PresenceWeb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PresenceWeb>
 *
 * @method PresenceWeb|null find($id, $lockMode = null, $lockVersion = null)
 * @method PresenceWeb|null findOneBy(array $criteria, array $orderBy = null)
 * @method PresenceWeb[]    findAll()
 * @method PresenceWeb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PresenceWebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PresenceWeb::class);
    }

//    /**
//     * @return PresenceWeb[] Returns an array of PresenceWeb objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PresenceWeb
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
