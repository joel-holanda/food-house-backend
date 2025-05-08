<?php

namespace App\Repository;

use App\Entity\StoreContact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StoreContact>
 *
 * @method StoreContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoreContact[]    findAll()
 * @method StoreContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreContact::class);
    }

//    /**
//     * @return StoreContact[] Returns an array of StoreContact objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StoreContact
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
