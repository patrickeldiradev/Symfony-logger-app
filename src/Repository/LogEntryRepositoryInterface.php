<?php

namespace App\Repository;

use App\DTO\LogCountRequestTransfer;

interface LogEntryRepositoryInterface
{
    /**
     * @param LogCountRequestTransfer $requestTransfer
     * @return int
     */
    public function countLogs(LogCountRequestTransfer $requestTransfer): int;
}
