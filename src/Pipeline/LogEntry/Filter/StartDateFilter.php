<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

class StartDateFilter
{
    private ?string $startDate;

    /**
     * StartDateFilter constructor.
     *
     * @param string|null $startDate
     */
    public function __construct(?string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Invokes the filter to add a start date condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     * @throws \Exception
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if ($this->startDate !== null) {
            $criteria->andWhere(Criteria::expr()->gte('timestamp', new \DateTime($this->startDate)));
        }

        return $criteria;
    }
}
