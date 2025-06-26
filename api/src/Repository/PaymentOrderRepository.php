<?php

namespace App\Repository;

use App\Entity\PaymentOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentOrder>
 */
class PaymentOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentOrder::class);
    }

    public function create(PaymentOrder $paymentorder, bool $flush = false): ?PaymentOrder
    {
        $this->getEntityManager()->persist($paymentorder);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
        return $paymentorder;
    }

    public function update(PaymentOrder $paymentorder): ?PaymentOrder
    {
        $this->create($paymentorder, true);
        return $paymentorder;
    }

    public function delete(PaymentOrder $paymentorder, bool $flush = false): void
    {
        $this->getEntityManager()->remove($paymentorder);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /**
    * @return PaymentOrder Returns  PaymentOrder objects
    */
    public function findById(string $value): ?PaymentOrder
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.session_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
