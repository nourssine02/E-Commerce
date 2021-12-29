<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\SearchBar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }


    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findSearch(SearchBar $searchBar): array
    {
        $query = $this->createQueryBuilder('p');

        if(!empty($searchBar->a)){
            $query = $query
                ->andWhere('p.name LIKE :a')
                ->setParameter('a',"%{$searchBar->a}%");
        }

        if (!empty($searchBar->minPrice)) {
            $query = $query
                ->andWhere('a.prix >= :minPrice')
                ->setParameter('minPrice', $searchBar->minPrice);
        }
        if (!empty($searchBar->maxPrice)) {
            $query = $query
                ->andWhere('a.prix <= :maxPrice')
                ->setParameter('maxPrice', $searchBar->maxPrice);
        }
        return $query->getQuery()->getResult();

    }


    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */

    // public function findByPrix($critere)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->andWhere('c.prix = :prix')
    //         ->setParameter('prix', $critere['prix']->getPrix())
    //         ->orderBy('c.prix', 'ASC')
    //         ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }


    /*
    public function findOneBySomeField($value): ?Article
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
