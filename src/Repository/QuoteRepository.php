<?php

namespace App\Repository;

use App\Entity\Quote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Quote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quote[]    findAll()
 * @method Quote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    //Uses RAND() function, but not working for SQLite DB so unconvenient for test purpose
    public function findRandom()
    {
        return $this->createQueryBuilder('q')
            ->select('q', 'COUNT(l) AS nbLikes')
            ->leftJoin('q.likes', 'l')
            ->orderBy('RAND()')
            ->groupBy('q')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //Uses RAND() function, but not working for SQLite DB so unconvenient for test purpose
    public function findRandomByCategory(string $category)
    {
        return $this->createQueryBuilder('q')
            ->leftJoin('q.category', 'c')
            ->where('c.name LIKE :category')
            ->setParameter('category', $category)
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findRandomWithoutRand(?string $category)
    {
        if ($category !== null) {
            $allIds = $this->createQueryBuilder('q')
                ->select('q.id')
                ->innerJoin('q.category', 'c')
                ->where('c.name = :category')
                ->setParameter('category', $category)
                ->getQuery()
                ->getResult();
        } else {
            $allIds = $this->createQueryBuilder('q')
                ->select('q.id')
                ->getQuery()
                ->getResult();
        }

        if (count($allIds) > 0) {
            $randomId = $allIds[array_rand($allIds)];
        } else {
            $randomId = -1;
        }

        return $this->find($randomId);
    }
}
