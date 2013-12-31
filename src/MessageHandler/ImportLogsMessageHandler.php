<?php

namespace App\MessageHandler;

use App\Message\ImportLogsMessage;
use App\Service\ImportLogsService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;
use Throwable;

/**
 * Handles ImportLogsMessage to trigger the import logs process.
 */
#[AsMessageHandler]
class ImportLogsMessageHandler
{
    /**
     * @var ImportLogsService The service responsible for importing logs.
     */
    private ImportLogsService $importLogsService;

    /**
     * @var LoggerInterface The logger for logging errors.
     */
    private LoggerInterface $logger;

    /**
     * Constructor.
     *
     * @param ImportLogsService $importLogsService The service responsible for importing logs.
     * @param LoggerInterface $logger The logger for logging errors.
     */
    public function __construct(ImportLogsService $importLogsService, LoggerInterface $logger)
    {
        $this->importLogsService = $importLogsService;
        $this->logger = $logger;
    }

    /**
     * Handles the ImportLogsMessage by invoking the ImportLogsService to execute the import process.
     *
     * @param ImportLogsMessage $message The message containing data or instructions for importing logs.
     * @return void
     */
    public function __invoke(ImportLogsMessage $message): void
    {
        try {
            $this->importLogsService->execute($message->getLogFilePath());
        } catch (Throwable $e) {
            $this->logger->error(
                'Failed to import logs: ' . $e->getMessage(),
                ['exception' => $e]
            );
        }
    }
}