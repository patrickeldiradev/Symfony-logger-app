<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\Common\Collections\Criteria;

interface FilterInterface
{
    /**
     * Invokes the filter to add a service name condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function __invoke(Criteria $criteria): Criteria;
}
