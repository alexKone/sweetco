<?php

namespace App\Repository;

use App\Entity\Bagel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Bagel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bagel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bagel[]    findAll()
 * @method Bagel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BagelRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Bagel::class);
    }

    // /**
    //  * @return Bagel[] Returns an array of Bagel objects
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
    public function findOneBySomeField($value): ?Bagel
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
