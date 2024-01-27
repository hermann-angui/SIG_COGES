<?php

namespace App\Repository;

use App\Entity\PosteOrgane;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PosteOrgane>
 *
 * @method PosteOrgane|null find($id, $lockMode = null, $lockVersion = null)
 * @method PosteOrgane|null findOneBy(array $criteria, array $orderBy = null)
 * @method PosteOrgane[]    findAll()
 * @method PosteOrgane[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PosteOrganeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PosteOrgane::class);
    }

//    /**
//     * @return PosteOrgane[] Returns an array of PosteOrgane objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PosteOrgane
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
