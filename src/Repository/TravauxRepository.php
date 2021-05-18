<?php

namespace App\Repository;

use App\Entity\Travaux;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Travaux|null find($id, $lockMode = null, $lockVersion = null)
 * @method Travaux|null findOneBy(array $criteria, array $orderBy = null)
 * @method Travaux[]    findAll()
 * @method Travaux[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TravauxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Travaux::class);
        
    }
    
    public function rechercher(string $texte)
    {
        return $this->createQueryBuilder('t')
            ->where('t.titre LIKE :text')
            ->setParameter('text','%'.$texte.'%')
            ->getQuery()
            ->getResult();
    }
}
