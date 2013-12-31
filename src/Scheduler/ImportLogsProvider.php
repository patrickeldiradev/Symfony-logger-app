<?php

namespace App\Scheduler;

use App\Message\ImportLogsMessage;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

/**
 * Class ImportLogsProvider
 *
 * Provides a schedule for recurring import logs tasks.
 */
#[AsSchedule('watchlogs')]
class ImportLogsProvider implements ScheduleProviderInterface
{
    /**
     * @var string The log file path.
     */
    private string $logFilePath;

    /**
     * Constructor.
     *
     * @param string $logFilePath The log file path.
     */
    public function __construct(string $logFilePath)
    {
        $this->logFilePath = $logFilePath;
    }

    /**
     * Gets the schedule for importing logs.
     *
     * @return Schedule The schedule for importing logs.
     */
    public function getSchedule(): Schedule
    {
        // Run the import every 3 seconds
        return (new Schedule())->add(
            RecurringMessage::every('3 seconds', new ImportLogsMessage($this->logFilePath))
        );
    }
}