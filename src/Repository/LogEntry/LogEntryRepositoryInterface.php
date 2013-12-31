<?php

namespace App\Repository\LogEntry;

use App\DTO\LogEntry\LogCountRequestTransfer;

interface LogEntryRepositoryInterface
{
    /**
     * @param LogCountRequestTransfer $requestTransfer
     * @return int
     */
    public function countLogs(LogCountRequestTransfer $requestTransfer): int;
}
