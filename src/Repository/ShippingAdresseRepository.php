<?php

namespace App\Repository;

use App\Entity\ShippingAdresse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ShippingAdresse>
 *
 * @method ShippingAdresse|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingAdresse|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingAdresse[]    findAll()
 * @method ShippingAdresse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingAdresseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingAdresse::class);
    }

//    /**
//     * @return ShippingAdresse[] Returns an array of ShippingAdresse objects
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

//    public function findOneBySomeField($value): ?ShippingAdresse
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
