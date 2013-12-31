<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\ORM\QueryBuilder;

class StartDateFilter
{
    /**
     * @var string|null
     */
    private ?string $startDate;

    /**
     * @param string|null $startDate
     */
    public function __construct(?string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function __invoke(QueryBuilder $qb): QueryBuilder
    {
        if ($this->startDate !== null) {
            $qb->andWhere('l.timestamp >= :startDate')
                ->setParameter('startDate', $this->startDate);
        }

        return $qb;
    }
}
