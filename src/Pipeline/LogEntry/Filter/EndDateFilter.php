<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\ORM\QueryBuilder;

class EndDateFilter
{
    /**
     * @var string|null
     */
    private ?string $endDate;

    /**
     * @param string|null $endDate
     */
    public function __construct(?string $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function __invoke(QueryBuilder $qb): QueryBuilder
    {
        if ($this->endDate !== null) {
            $qb->andWhere('l.timestamp <= :endDate')
                ->setParameter('endDate', $this->endDate);
        }

        return $qb;
    }
}
