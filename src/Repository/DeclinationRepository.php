<?php

namespace App\Repository;

use App\Entity\Declination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Declination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Declination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Declination[]    findAll()
 * @method Declination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeclinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Declination::class);
    }

    // /**
    //  * @return Declination[] Returns an array of Declination objects
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
    public function findOneBySomeField($value): ?Declination
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
