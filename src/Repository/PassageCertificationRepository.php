<?php

namespace App\Repository;

use App\Entity\PassageCertification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PassageCertification>
 *
 * @method PassageCertification|null find($id, $lockMode = null, $lockVersion = null)
 * @method PassageCertification|null findOneBy(array $criteria, array $orderBy = null)
 * @method PassageCertification[]    findAll()
 * @method PassageCertification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassageCertificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PassageCertification::class);
    }

//    /**
//     * @return PassageCertification[] Returns an array of PassageCertification objects
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

//    public function findOneBySomeField($value): ?PassageCertification
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
