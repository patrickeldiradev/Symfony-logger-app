<?php

namespace App\Pipeline\LogEntry\Filter;

use App\DTO\LogEntry\LogCountRequestTransfer;
use Doctrine\Common\Collections\Criteria;

class StartDateFilter implements FilterInterface
{
    /**
     * @var LogCountRequestTransfer
     */
    private LogCountRequestTransfer $requestTransfer;

    /**
     * ServiceNameFilter constructor.
     *
     * @param LogCountRequestTransfer $requestTransfer
     */
    public function __construct(LogCountRequestTransfer $requestTransfer)
    {
        $this->requestTransfer = $requestTransfer;
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
        if ($this->requestTransfer->getStartDate() !== null) {
            $criteria->andWhere(
                Criteria::expr()
                    ->gte(
                        'timestamp',
                        new \DateTime($this->requestTransfer->getStartDate())
                    )
            );
        }

        return $criteria;
    }
}
