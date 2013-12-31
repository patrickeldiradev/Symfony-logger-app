<?php

namespace App\Pipeline\LogEntry;

use App\Pipeline\LogEntry\Filter\FilterInterface;
use Doctrine\Common\Collections\Criteria;

class LogFilterPipeline implements LogFilterPipelineInterface
{
    /**
     * @var array<FilterInterface>
     */
    private array $filters;

    /**
     * @param array<FilterInterface> $filters
     */
    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
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
