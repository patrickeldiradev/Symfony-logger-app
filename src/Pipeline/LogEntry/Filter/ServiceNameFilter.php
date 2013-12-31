<?php

namespace App\Pipeline\LogEntry\Filter;

use App\DTO\LogEntry\LogCountRequestTransfer;
use Doctrine\Common\Collections\Criteria;

class ServiceNameFilter implements FilterInterface
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
     * Invokes the filter to add a service name condition to the Criteria object.
     *
     * @param Criteria $criteria
     * @return Criteria
     */
    public function __invoke(Criteria $criteria): Criteria
    {
        if (!empty($this->requestTransfer->getServiceNames())) {
            $criteria->andWhere(Criteria::expr()->in(
                'serviceName',
                $this->requestTransfer->getServiceNames()
            ));
        }

        return $criteria;
    }
}
