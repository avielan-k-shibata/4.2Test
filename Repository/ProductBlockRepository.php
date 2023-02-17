<?php

namespace Plugin\Test\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\Test\Entity\ProductBlock;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * ProductBlockRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductBlockRepository extends AbstractRepository
{
    /**
     * ProductBlockRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductBlock::class);
    }


    // /**
    //  * @return ProductItem[] Returns an array of ProductItem objects
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
    public function findOneBySomeField($value): ?ProductItem
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
