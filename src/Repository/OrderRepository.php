<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function countAllOrder()
    {
        $qb = $this->createQueryBuilder('e');
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    // for user
    public function countOrderUser($user)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.user = :user')
            ->setParameter('user', $user);
        $qb ->select($qb->expr()->count('e'));
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    // for user
    public function findOrderUser($user)
    {
        $qb = $this->createQueryBuilder('p')
            ->where('p.user = :user')
            ->setParameter('user', $user);
        $query = $qb->getQuery();
        return $query->execute();
    }

    // for user
    public function findAllOrderAdmin()
    {
        $qb = $this->createQueryBuilder('p');

        $query = $qb->getQuery();
        return $query->execute();
    }











    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
