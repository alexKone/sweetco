<?php

namespace App\Repository;

use App\Entity\Panini;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Panini|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panini|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panini[]    findAll()
 * @method Panini[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaniniRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Panini::class);
    }

    // /**
    //  * @return Panini[] Returns an array of Panini objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Panini
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
