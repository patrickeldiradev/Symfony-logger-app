<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\Common\Collections\Criteria;

class StatusCodeFilter
{
    private ?int $statusCode;

    /**
     * StatusCodeFilter constructor.
     *
     * @param int|null $statusCode
     */
    public function __construct(?int $statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * Invokes the filter to add a status code condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if ($this->statusCode !== null) {
            $criteria->andWhere(Criteria::expr()->eq('statusCode', $this->statusCode));
        }

        return $criteria;
    }
}
