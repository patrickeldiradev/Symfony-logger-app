<?php

namespace App\Pipeline\LogEntry;

use Doctrine\Common\Collections\Criteria;

class LogFilterPipeline
{
    /**
     * @var array<callable>
     */
    private array $filters = [];

    /**
     * Adds a filter to the pipeline.
     *
     * @param callable $filter
     * @return $this
     */
    public function addFilter(callable $filter): self
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Applies all filters in the pipeline to the given Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function apply(Criteria $criteria): Criteria
    {
        foreach ($this->filters as $filter) {
            $criteria = $filter($criteria);
        }

        return $criteria;
    }
}
