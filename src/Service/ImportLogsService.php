<?php

namespace App\Service;

use App\Entity\LogEntry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Service class for importing logs from a file into the database.
 */
class ImportLogsService implements ImportLogsServiceInterface
{
    /**
     * @var EntityManagerInterface The entity manager instance.
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var LoggerInterface The logger instance for logging errors.
     */
    private LoggerInterface $logger;

    /**
     * @var TranslatorInterface The translator instance for translating messages.
     */
    private TranslatorInterface $translator;

    /**
     * @var string The read mode for opening the log file.
     */
    private const READ_MODE = 'r';

    /**
     * @var array<LogEntry> The batch of log entries to process and save.
     */
    private array $batch = [];

    /**
     * @var string Regular expression pattern to parse each log line.
     */
    private const LINE_EXPRESSION = '/(\S+) - - \[(.+?)\] "(\S+) (\S+) (\S+)" (\d+)/';

    /**
     * @var int The size of each batch to process.
     */
    private const CHUNK_SIZE = 5000;

    /**
     * Constructor.
     *
     * @param EntityManagerInterface $entityManager The entity manager instance.
     * @param LoggerInterface $logger The logger instance for logging errors.
     * @param TranslatorInterface $translator The translator instance for translating messages.
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        LoggerInterface $logger,
        TranslatorInterface $translator,
    ) {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->translator = $translator;
    }

    /**
     * Executes the import process.
     *
     * @param string $logFilePath The path to the log file.
     * @return int Returns Command::SUCCESS on success, or Command::FAILURE on failure.
     */
    public function execute(string $logFilePath): int
    {
        if (!file_exists($logFilePath)) {
            $this->logger->error(
                $this->translator->trans('log_file_not_exist', ['%file%' => $logFilePath])
            );
            return Command::FAILURE;
        }

        $handle = @fopen($logFilePath, self::READ_MODE);

        if ($handle === false) {
            $this->logger->error(
                $this->translator->trans('log_file_open_fail', ['%file%' => $logFilePath])
            );

            return Command::FAILURE;
        }

        $lastPosition = $this->getLastPosition();

        fseek($handle, $lastPosition);

        $this->processBatches($handle);

        fclose($handle);

        return Command::SUCCESS;
    }

    /**
     * Processes log batches from the file handle.
     *
     * @param resource $handle The file handle resource.
     * @return void
     */
    private function processBatches($handle): void
    {
        while (($line = fgets($handle)) !== false) {
            if (empty(trim($line))) {
                continue;
            }

            $this->batch[] = $this->createLogEntry($line, ftell($handle));

            if (count($this->batch) >= self::CHUNK_SIZE) {
                $this->saveBatch();
                break;
            }
        }

        $this->saveBatch();
    }

    /**
     * Retrieves the last position processed in the log file.
     *
     * @return int The last position processed.
     */
    private function getLastPosition(): int
    {
        $lastLog = $this->entityManager
            ->getRepository(LogEntry::class)
            ->findOneBy([], ['linePosition' => 'DESC']);

        return $lastLog ? $lastLog->getLinePosition() : 0;
    }

    /**
     * Creates a LogEntry object from a line of log data.
     *
     * @param string $line The line of log data.
     * @param int $lastPosition The last position in the log file.
     * @return LogEntry The created LogEntry object.
     */
    private function createLogEntry(string $line, int $lastPosition): LogEntry
    {
        $line = preg_replace('/^\xEF\xBB\xBF/', '', $line);
        $line = trim($line);
        $matches = [];

        preg_match(self::LINE_EXPRESSION, $line, $matches);

        $logEntry = new LogEntry();
        $logEntry->setServiceName(! empty(trim($matches[1])) ? trim($matches[1]) : '');
        $logEntry->setTimestamp(isset($matches[2]) ? new \DateTime($matches[2]) : new \DateTime());
        $logEntry->setHttpMethod($matches[3] ?? '');
        $logEntry->setUri($matches[4] ?? '');
        $logEntry->setHttpVersion($matches[5] ?? '');
        $logEntry->setStatusCode(! empty($matches[6]) ? (int)$matches[6] : null);
        $logEntry->setLinePosition($lastPosition);

        return $logEntry;
    }

    /**
     * Saves the current batch of LogEntry objects to the database.
     *
     * @return void
     */
    private function saveBatch(): void
    {
        $this->entityManager->wrapInTransaction(function ($entityManager) {
            foreach ($this->batch as $logEntry) {
                $entityManager->persist($logEntry);
            }
            $entityManager->flush();
        });

        $this->batch = [];
    }
}
