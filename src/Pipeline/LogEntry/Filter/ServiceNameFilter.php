<?php

namespace App\Pipeline\LogEntry\Filter;

use Doctrine\ORM\QueryBuilder;

class ServiceNameFilter
{
    /**
     * @var array
     */
    private array $serviceNames;

    /**
     * @param array $serviceNames
     */
    public function __construct(array $serviceNames)
    {
        $this->serviceNames = $serviceNames;
    }

    /**
     * @param QueryBuilder $qb
     * @return QueryBuilder
     */
    public function __invoke(QueryBuilder $qb): QueryBuilder
    {
        if (!empty($this->serviceNames)) {
            $qb->andWhere($qb->expr()->in('l.serviceName', ':serviceNames'))
                ->setParameter('serviceNames', $this->serviceNames);
        }

        return $qb;
    }
}
