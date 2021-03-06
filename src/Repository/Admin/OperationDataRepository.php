<?php

namespace App\Repository\Admin;

use App\Entity\Admin\OperationData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method OperationData|null find($id, $lockMode = null, $lockVersion = null)
 * @method OperationData|null findOneBy(array $criteria, array $orderBy = null)
 * @method OperationData[]    findAll()
 * @method OperationData[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationDataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, OperationData::class);
    }

    // /**
    //  * @return OperationData[] Returns an array of OperationData objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OperationData
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
