<?php

namespace App\Repository;

use App\Entity\CartProduct;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CartProduct>
 */
class CartProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartProduct::class);
    }

      public function create(CartProduct $cartProduct, bool $flush = false): ?CartProduct
    {
        $this->getEntityManager()->persist($cartProduct);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $cartProduct;
    }

    public function update(CartProduct $cartProduct): ?CartProduct
    {
        $this->create($cartProduct, true);
        return $cartProduct;
    }

    public function delete(CartProduct $cartProduct, bool $flush = false): void
    {
        $this->getEntityManager()->remove($cartProduct);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByProduct(Product $product, string $session_id): CartProduct | null
    {
        return $this->createQueryBuilder('cp')
            ->join('cp.products', 'p')
            ->andWhere('p.id = :product')
            ->andWhere('cp.session_id = :val')
            ->setParameter('product', $product->getId())
            ->setParameter('val', $session_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
