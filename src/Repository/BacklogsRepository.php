<?php

namespace App\Repository;

use App\Entity\Backlogs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Backlogs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Backlogs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Backlogs[]    findAll()
 * @method Backlogs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BacklogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Backlogs::class);
    }

    // /**
    //  * @return Backlogs[] Returns an array of Backlogs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Backlogs
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
