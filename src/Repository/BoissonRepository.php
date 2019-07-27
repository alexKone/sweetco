<?php

namespace App\Repository;

use App\Entity\Boisson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Boisson|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boisson|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boisson[]    findAll()
 * @method Boisson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoissonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Boisson::class);
    }

	/**
	 * @param $slug
	 *
	 * @return mixed
	 */
	public function getBySlug( $slug ) {
		return $this->createQueryBuilder('b')
			->andWhere('b.slug = :slug')
			->setParameter('slug', $slug)
			->setMaxResults(1)
			->getQuery()
			->getResult();
    }

    // /**
    //  * @return Boisson[] Returns an array of Boisson objects
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
    public function findOneBySomeField($value): ?Boisson
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
