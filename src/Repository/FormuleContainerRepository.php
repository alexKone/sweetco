<?php

namespace App\Repository;

use App\Entity\FormuleContainer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FormuleContainer|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormuleContainer|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormuleContainer[]    findAll()
 * @method FormuleContainer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormuleContainerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FormuleContainer::class);
    }

    // /**
    //  * @return FormuleContainer[] Returns an array of FormuleContainer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormuleContainer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
