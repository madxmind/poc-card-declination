<?php

namespace App\Repository;

use App\Entity\DeclinationCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DeclinationCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeclinationCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeclinationCategory[]    findAll()
 * @method DeclinationCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclinationCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeclinationCategory::class);
    }

    // /**
    //  * @return DeclinationCategory[] Returns an array of DeclinationCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DeclinationCategory
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
