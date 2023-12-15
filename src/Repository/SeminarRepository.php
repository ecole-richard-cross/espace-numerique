<?php

namespace App\Repository;

use App\Entity\Seminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seminar>
 *
 * @method Seminar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seminar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seminar[]    findAll()
 * @method Seminar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeminarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seminar::class);
    }

    public function findPublishedByRoles(array $roles)
    {
        $seminars = $this->findBy(['isPublished' => true]);
        $allowedSeminars = array_filter($seminars, function ($seminar) use ($roles) {
            $inter = array_intersect($seminar->getRoles(), $roles);
            if (empty($inter))
                return false;
            return true;
        });
        return $allowedSeminars;
    }

    public function searchFor(string $query)
    {
        return $this->createQueryBuilder('d')
            ->orWhere('LOWER(d.title) LIKE LOWER(:q)')
            ->orWhere('d.description LIKE :q')
            ->setParameter('q', '%' . $query . '%', 'string')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Seminar[] Returns an array of Seminar objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneById($value): ?Seminar
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.id = :id')
    //            ->setParameter('id', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
