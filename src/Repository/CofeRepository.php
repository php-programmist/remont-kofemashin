<?php

namespace App\Repository;

use App\Entity\Cofe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cofe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cofe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cofe[]    findAll()
 * @method Cofe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CofeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cofe::class);
    }

    // /**
    //  * @return Cofe[] Returns an array of Cofe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cofe
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
