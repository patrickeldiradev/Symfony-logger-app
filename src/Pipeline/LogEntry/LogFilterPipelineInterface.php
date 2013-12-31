<?php

namespace App\Pipeline\LogEntry;

use Doctrine\Common\Collections\Criteria;

interface LogFilterPipelineInterface
{
    /**
     * Applies all filters in the pipeline to the given Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function apply(Criteria $criteria): Criteria;
}
