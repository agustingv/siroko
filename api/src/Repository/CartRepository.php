<?php

namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Cart>
 */
class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

       /**
        * @return Cart Returns  Cart objects
        */
       public function findById(int $value): ?Cart
       {
           return $this->createQueryBuilder('c')
               ->andWhere('c.id = :val')
               ->setParameter('val', $value)
               ->getQuery()
               ->getResult()
           ;
       }
}
