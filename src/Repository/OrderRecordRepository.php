<?php

namespace App\Repository;

use App\Entity\OrderRecord;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderRecord>
 *
 * @method OrderRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrderRecord[]    findAll()
 * @method OrderRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderRecord::class);
    }

//    /**
//     * @return OrderRecord[] Returns an array of OrderRecord objects
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

//    public function findOneBySomeField($value): ?OrderRecord
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
