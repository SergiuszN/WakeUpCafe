<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use AppBundle\Util\TimeHelper;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\QueryException;

/**
 * ReservationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ReservationRepository extends EntityRepository
{
    /**
     * @return \Doctrine\ORM\Query
     */
    public function getAdminListQuery()
    {
        return $this->createQueryBuilder('r')
            ->select('r, a, b')
            ->leftJoin('r.author', 'a')
            ->leftJoin('r.bench', 'b')
            ->addOrderBy('r.date', 'DESC')
            ->getQuery();
    }

    /**
     * @param User $user
     * @return \Doctrine\ORM\Query
     */
    public function getUserListQuery(User $user)
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->andWhere('r.author = :author')
            ->addOrderBy('r.date', 'DESC')
            ->setParameter('author', $user)
            ->getQuery();
    }

    /**
     * @return int
     */
    public function findTodayCount()
    {
        $dates = TimeHelper::getTodayDates();

        try {
            return $this->createQueryBuilder('r')
                ->select('COUNT(r)')
                ->andWhere('r.date >= :start')
                ->andWhere('r.date < :end')
                ->setParameter('start', $dates->start)
                ->setParameter('end', $dates->end)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (QueryException $e) {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function findTomorrowCount()
    {
        $dates = TimeHelper::getTomorrowDates();

        try {
            return $this->createQueryBuilder('r')
                ->select('COUNT(r)')
                ->andWhere('r.date >= :start')
                ->andWhere('r.date < :end')
                ->setParameter('start', $dates->start)
                ->setParameter('end', $dates->end)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (QueryException $e) {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function findWeekCount()
    {
        $dates = TimeHelper::getLast7Dates();

        try {
            return $this->createQueryBuilder('r')
                ->select('COUNT(r)')
                ->andWhere('r.date >= :start')
                ->andWhere('r.date < :end')
                ->setParameter('start', $dates->start)
                ->setParameter('end', $dates->end)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (QueryException $e) {
            return 0;
        }
    }
}
