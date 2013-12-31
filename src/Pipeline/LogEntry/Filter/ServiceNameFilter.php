<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

class ServiceNameFilter
{
    /**
     * @var array<string>
     */
    private array $serviceNames;

    /**
     * ServiceNameFilter constructor.
     *
     * @param array<string> $serviceNames
     */
    public function __construct(array $serviceNames)
    {
        $this->serviceNames = $serviceNames;
    }

    /**
     * Invokes the filter to add a service name condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if (!empty($this->serviceNames)) {
            $criteria->andWhere(Criteria::expr()->in('serviceName', $this->serviceNames));
        }

        return $criteria;
    }
}
