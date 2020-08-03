<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Common\Collections\Criteria;

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
    * @return Article[]
    */
    public function findAllPublishedOrderedByNewest()
    {
        $qb = $this->createQueryBuilder('a');
        return $this->addIsPublishedQueryBuilder($qb)
                    ->leftJoin('a.tags', 't')
                    ->addSelect('t')
                    ->orderBy('a.publishedAt', 'DESC')
                    ->getQuery()
                    ->getResult()
        ;
    }

    public static function createNonDeletedCriteria(): Criteria
    {
        return Criteria::create()
                ->andWhere(Criteria::expr()->eq('isDeleted', false))
                ->orderBy(['createdAt' => 'DESC']);
    }

    private function addIsPublishedQueryBuilder(QueryBuilder $qb)
    {
        return $this->getOrCreateQueryBuilder($qb)
                    ->andWhere('a.publishedAt IS NOT NULL');
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?:$this->createQueryBuilder('a');
    }
}
