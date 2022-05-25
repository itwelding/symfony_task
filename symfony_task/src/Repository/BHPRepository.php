<?php

namespace App\Repository;

use App\Entity\BHP;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BHP|null find($id, $lockMode = null, $lockVersion = null)
 * @method BHP|null findOneBy(array $criteria, array $orderBy = null)
 * @method BHP[]    findAll()
 * @method BHP[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BHPRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BHP::class);
    }

    // /**
    //  * @return BHP[] Returns an array of BHP objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BHP
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
