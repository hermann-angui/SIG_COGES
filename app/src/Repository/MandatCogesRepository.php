<?php

namespace App\Repository;

use App\Entity\MandatCoges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MandatCoges>
 *
 * @method MandatCoges|null find($id, $lockMode = null, $lockVersion = null)
 * @method MandatCoges|null findOneBy(array $criteria, array $orderBy = null)
 * @method MandatCoges[]    findAll()
 * @method MandatCoges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MandatCogesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MandatCoges::class);
    }

//    /**
//     * @return MandatCoges[] Returns an array of MandatCoges objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MandatCoges
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
