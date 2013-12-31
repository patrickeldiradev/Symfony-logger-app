<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\ORM\QueryBuilder;

class StatusCodeFilter
{
    /**
     * @var int|null
     */
    private ?int $statusCode;

    /**
     * @param int|null $statusCode
     */
    public function __construct(?int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function __invoke(QueryBuilder $qb): QueryBuilder
    {
        if ($this->statusCode !== null) {
            $qb->andWhere('l.statusCode = :statusCode')
                ->setParameter('statusCode', $this->statusCode);
        }

        return $qb;
    }
}
