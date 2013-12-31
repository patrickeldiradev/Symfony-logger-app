<?php

namespace App\Pipeline\LogEntry;

use Doctrine\ORM\QueryBuilder;

class LogFilterPipeline
{
    /**
     * @var array
     */
    private array $filters = [];

    /**
     * @param callable $filter
     * @return $this
     */
    public function addFilter(callable $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function apply(QueryBuilder $qb): QueryBuilder
    {
        foreach ($this->filters as $filter) {
            $qb = $filter($qb);
        }

        return $qb;
    }
}
