<?php

namespace App\Pipeline\LogEntry\Filter;

use App\DTO\LogEntry\LogCountRequestTransfer;
use Doctrine\Common\Collections\Criteria;

class EndDateFilter implements FilterInterface
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
     * Invokes the filter to add an end date condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     * @throws \Exception
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if ($this->requestTransfer->getEndDate() !== null) {
            $criteria->andWhere(
                Criteria::expr()
                    ->lte(
                        'timestamp',
                        new \DateTime($this->requestTransfer->getEndDate())
                    )
            );
        }

        return $criteria;
    }
}
