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

    public function create(Cart $cart, bool $flush = false): ?Cart
    {
        $this->getEntityManager()->persist($cart);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $cart;
    }

    public function update(Cart $cart): ?Cart
    {
        $this->create($cart, true);
        return $cart;
    }

    public function delete(Cart $cart, bool $flush = false): void
    {
        $this->getEntityManager()->remove($cart);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    * @return Cart Returns  Cart objects
    */
    public function findById(string $value): ?Cart
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.session_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
