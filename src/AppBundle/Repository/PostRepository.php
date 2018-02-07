<?php

namespace AppBundle\Repository;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    public function getArticleSortRang()
    {
        return $queryBuilder = $this
            ->createQueryBuilder('p')
            ->orderBy('p.rang', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function searchArticle($search)
    {
        return $queryBuilder = $this
            ->createQueryBuilder('p')
            ->andWhere('p.title LIKE :er')
            ->orderBy('p.rang', 'DESC')
            ->setParameter('er', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }
}
