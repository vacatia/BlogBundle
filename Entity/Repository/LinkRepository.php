<?php

namespace Desarrolla2\Bundle\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Desarrolla2\Bundle\BlogBundle\Model\LinkStatus;
use DateTime;

/**
 * LinkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class LinkRepository extends EntityRepository
{

    /**
     *
     * @return array
     */
    public function getActive()
    {
        $query = $this->getQueryForGetActive();

        return $query->getResult();
    }

    /**
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForGetActive()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT l FROM BlogBundle:Link l ' .
            ' WHERE l.isPublished = ' . LinkStatus::PUBLISHED .
            ' ORDER BY l.createdAt DESC '
        );

        return $query;
    }

    /**
     *
     * @return array
     */
    public function getActiveOrdered()
    {
        $query = $this->getQueryForGetActiveOrdered();

        return $query->getResult();
    }

    /**
     *
     * @return \Doctrine\ORM\Query
     */
    public function getQueryForGetActiveOrdered()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT l FROM BlogBundle:Link l ' .
            ' WHERE l.isPublished = ' . LinkStatus::PUBLISHED .
            ' ORDER BY l.name ASC '
        );

        return $query;
    }

    /**
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilderForFilter()
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb
            ->select('l')
            ->from('BlogBundle:Link', 'l')
            ->orderBy('l.updatedAt', 'DESC');

        return $qb;
    }

    /**
     * Count published elements from date
     *
     * @param  DateTime $date
     * @return int
     */
    public function countFromDate(DateTime $date)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT COUNT(l) FROM BlogBundle:Link l ' .
            ' WHERE l.isPublished = ' . LinkStatus::PUBLISHED .
            ' AND l.createdAt >= :date '
        )
            ->setParameter('date', $date);

        return $query->getSingleScalarResult();
    }

    /**
     *
     * @param  DateTime $date
     * @param  int      $limit
     * @return array
     */
    public function getMoreActiveFromDate(DateTime $date, $limit = 10)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            ' SELECT l ' .
            ' FROM BlogBundle:Link l ' .
            ' JOIN l.Post p ' .
            ' WHERE l.isPublished = ' . LinkStatus::PUBLISHED .
            ' AND l.createdAt >= :date ' .
            ' GROUP BY l ' .
            ' ORDER BY n DESC '
        )
            ->setParameter('date', $date)
            ->setMaxResults($limit);
    }
}
