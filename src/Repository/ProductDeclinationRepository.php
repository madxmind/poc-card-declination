<?php

namespace App\Repository;

use App\Entity\ProductDeclination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductDeclination|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductDeclination|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductDeclination[]    findAll()
 * @method ProductDeclination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductDeclinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductDeclination::class);
    }

    // /**
    //  * @return ProductDeclination[] Returns an array of ProductDeclination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductDeclination
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
