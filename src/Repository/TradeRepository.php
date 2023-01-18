<?php

namespace App\Repository;

use App\Entity\Trade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trade>
 *
 * @method Trade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trade[]    findAll()
 * @method Trade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trade::class);
    }

    public function add(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function removeStrategy(int $strategyId): void
    {
        $qb = $this->createQueryBuilder('t')
            ->update()
            ->set('t.strategy', ':newStrategyId')
            ->setParameter('newStrategyId', null)
            ->where('t.strategy = :strategyId')
            ->setParameter('strategyId', $strategyId);
        $query = $qb->getQuery();
        $query->execute();
    }
    

    // public function findByuser(int $user): array
    // {
    //     // return $this->createQueryBuilder('t')
    //     //     ->andWhere('t.user = :user')
    //     //     ->setParameter('user', $user)
    //     //     ->getQuery()
    //     //     ->getResult();
    //     $qb = $this->createQueryBuilder('t')
    //         ->where
    // }

//    /**
//     * @return Trade[] Returns an array of Trade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Trade
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
