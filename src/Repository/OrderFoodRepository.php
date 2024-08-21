<?php

namespace App\Repository;

use App\Entity\OrderFood;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderFood>
 *
 * @method OrderFood|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderFood|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderFood[]    findAll()
 * @method OrderFood[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderFoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderFood::class);
    }

//    /**
//     * @return OrderFood[] Returns an array of OrderFood objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OrderFood
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
