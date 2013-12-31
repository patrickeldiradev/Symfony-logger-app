<?php

namespace App\Message;

/**
 * Class ImportLogsMessage
 *
 * Represents a message to trigger the import logs process.
 */
class ImportLogsMessage
{
    /**
     * @var string The file path to the logs.
     */
    private string $logFilePath;

    /**
     * Constructor.
     *
     * @param string $logFilePath The file path to the logs.
     */
    public function __construct(string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    /**
     * Gets the log file path.
     *
     * @return string The log file path.
     */
    public function getLogFilePath(): string
    {
        return $this->logFilePath;
    }
}
