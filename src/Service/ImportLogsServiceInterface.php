<?php

namespace App\Service;

interface ImportLogsServiceInterface
{
    /**
     * Executes the import process.
     *
     * @param string $logFilePath The path to the log file.
     * @return int Returns Command::SUCCESS on success, or Command::FAILURE on failure.
     */
    public function execute(string $logFilePath): int;
}
