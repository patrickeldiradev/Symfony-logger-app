<?php

namespace App\Repository\LogEntry;

use App\DTO\LogEntry\LogCountRequestTransfer;
use App\Entity\LogEntry;
use App\Pipeline\LogEntry\Filter\EndDateFilter;
use App\Pipeline\LogEntry\Filter\ServiceNameFilter;
use App\Pipeline\LogEntry\Filter\StartDateFilter;
use App\Pipeline\LogEntry\Filter\StatusCodeFilter;
use App\Pipeline\LogEntry\LogFilterPipeline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogEntry>
 */
class LogEntryRepository extends ServiceEntityRepository implements LogEntryRepositoryInterface
{
    /**
     * LogEntryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogEntry::class);
    }

    /**
     * @param LogCountRequestTransfer $requestTransfer
     * @return int
     */
    public function countLogs(LogCountRequestTransfer $requestTransfer): int
    {
        $criteria = Criteria::create();
        $pipeline = new LogFilterPipeline();

        $pipeline->addFilter(new ServiceNameFilter($requestTransfer->getServiceNames()))
            ->addFilter(new StatusCodeFilter($requestTransfer->getStatusCode()))
            ->addFilter(new StartDateFilter($requestTransfer->getStartDate()))
            ->addFilter(new EndDateFilter($requestTransfer->getEndDate()));

        $criteria = $pipeline->apply($criteria);
        $logs = $this->matching($criteria);

        return $logs->count();
    }
}
