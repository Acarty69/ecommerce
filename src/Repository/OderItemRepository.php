<?php

namespace App\Repository;

use App\Entity\OderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OderItem>
 *
 * @method OderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method OderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method OderItem[]    findAll()
 * @method OderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OderItem::class);
    }

//    /**
//     * @return OderItem[] Returns an array of OderItem objects
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

//    public function findOneBySomeField($value): ?OderItem
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}