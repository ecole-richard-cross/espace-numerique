<?php

namespace App\Repository;

use App\Entity\CentreFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CentreFormation>
 *
 * @method CentreFormation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CentreFormation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CentreFormation[]    findAll()
 * @method CentreFormation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CentreFormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CentreFormation::class);
    }

//    /**
//     * @return CentreFormation[] Returns an array of CentreFormation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CentreFormation
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
