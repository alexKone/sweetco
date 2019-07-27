<?php

namespace App\Repository;

use App\Entity\Salade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Salade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salade[]    findAll()
 * @method Salade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaladeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Salade::class);
    }

    // /**
    //  * @return Salade[] Returns an array of Salade objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Salade
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
