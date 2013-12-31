<?php

namespace App\Repository;

use App\DTO\LogCountRequestTransfer;
use App\Entity\LogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class LogEntryRepository extends ServiceEntityRepository
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
        $qb = $this->createQueryBuilder('l')
            ->select('COUNT(l)')
            ->where('1 = 1');

        // Add filters based on LogCountRequestTransfer properties
        if ($requestTransfer->getServiceNames()) {
            $qb->andWhere($qb->expr()->in('l.serviceName', ':serviceNames'))
                ->setParameter('serviceNames', $requestTransfer->getServiceNames());
        }

        if ($requestTransfer->getStatusCode()) {
            $qb->andWhere('l.statusCode = :statusCode')
                ->setParameter('statusCode', $requestTransfer->getStatusCode());
        }

        if ($requestTransfer->getStartDate()) {
            $qb->andWhere('l.timestamp >= :startDate')
                ->setParameter('startDate', $requestTransfer->getStartDate());
        }

        if ($requestTransfer->getEndDate()) {
            $qb->andWhere('l.timestamp <= :endDate')
                ->setParameter('endDate', $requestTransfer->getEndDate());
        }

        return $qb->getQuery()->getSingleScalarResult();
    }
}
