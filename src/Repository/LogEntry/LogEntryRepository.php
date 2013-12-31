<?php

namespace App\Repository\LogEntry;

use App\DTO\LogEntry\LogCountRequestTransfer;
use App\Entity\LogEntry;
use App\Factory\LogEntryFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LogEntry>
 */
class LogEntryRepository extends ServiceEntityRepository implements LogEntryRepositoryInterface
{
    private LogEntryFactory $logEntryFactory;

    /**
     * LogEntryRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry, LogEntryFactory $logEntryFactory)
    {
        parent::__construct($registry, LogEntry::class);
        $this->logEntryFactory = $logEntryFactory;
    }

    /**
     * @param LogCountRequestTransfer $requestTransfer
     * @return int
     */
    public function countLogs(LogCountRequestTransfer $requestTransfer): int
    {
        $pipeline = $this->logEntryFactory->createLogFilterPipeline($requestTransfer);
        $criteria = Criteria::create();
        $criteria = $pipeline->apply($criteria);
        $logs = $this->matching($criteria);

        return $logs->count();
    }
}
