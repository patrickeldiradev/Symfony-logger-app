<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\QueryBuilder;

class EndDateFilter
{
    private ?string $endDate;

    /**
     * EndDateFilter constructor.
     *
     * @param string|null $endDate
     */
    public function __construct(?string $endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Invokes the filter to add an end date condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     * @throws \Exception
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if ($this->endDate !== null) {
            $criteria->andWhere(Criteria::expr()->lte('timestamp', new \DateTime($this->endDate)));
        }

        return $criteria;
    }
}
