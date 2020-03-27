<?php

namespace App\Repository;

use App\Entity\Infosup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Infosup|null find($id, $lockMode = null, $lockVersion = null)
 * @method Infosup|null findOneBy(array $criteria, array $orderBy = null)
 * @method Infosup[]    findAll()
 * @method Infosup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfosupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Infosup::class);
    }

    // /**
    //  * @return Infosup[] Returns an array of Infosup objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Infosup
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
