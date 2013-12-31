<?php

namespace App\Pipeline\LogEntry\Filter;

use App\DTO\LogEntry\LogCountRequestTransfer;
use Doctrine\Common\Collections\Criteria;

class StatusCodeFilter implements FilterInterface
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
     * Invokes the filter to add a status code condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if ($this->requestTransfer->getStatusCode() !== null) {
            $criteria->andWhere(Criteria::expr()->eq('statusCode', $this->requestTransfer->getStatusCode()));
        }

        return $criteria;
    }
}
