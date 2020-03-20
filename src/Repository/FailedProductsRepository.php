<?php

namespace App\Repository;

use App\Entity\FailedProducts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FailedProducts|null find($id, $lockMode = null, $lockVersion = null)
 * @method FailedProducts|null findOneBy(array $criteria, array $orderBy = null)
 * @method FailedProducts[]    findAll()
 * @method FailedProducts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FailedProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FailedProducts::class);
    }

    // /**
    //  * @return FailedProducts[] Returns an array of FailedProducts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FailedProducts
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
