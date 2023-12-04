<?php

namespace App\Repository;

use App\Entity\SeminarConsultation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SeminarConsultation>
 *
 * @method SeminarConsultation|null find($id, $lockMode = null, $lockVersion = null)
 * @method SeminarConsultation|null findOneBy(array $criteria, array $orderBy = null)
 * @method SeminarConsultation[]    findAll()
 * @method SeminarConsultation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeminarConsultationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SeminarConsultation::class);
    }

//    /**
//     * @return SeminarConsultation[] Returns an array of SeminarConsultation objects
//     */
//    public function findBySeminar($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.seminar = :seminar')
//            ->setParameter('seminar', $value)
//            ->orderBy('s.id', 'ASC')
//         //    ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SeminarConsultation
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
