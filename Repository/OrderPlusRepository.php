<?php

namespace Plugin\Test\Repository;

use Eccube\Repository\AbstractRepository;
use Plugin\Test\Entity\OrderPlus;
// use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * OrderDetailPlusRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OrderPlusRepository extends AbstractRepository
{
    /**
     * OrderDetailPlusRepository constructor.
     *
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OrderPlus::class);
    }

}
