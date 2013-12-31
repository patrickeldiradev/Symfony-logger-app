<?php

namespace App\Factory;

use App\DTO\LogEntry\LogCountRequestTransfer;
use App\Pipeline\LogEntry\Filter\EndDateFilter;
use App\Pipeline\LogEntry\Filter\ServiceNameFilter;
use App\Pipeline\LogEntry\Filter\StartDateFilter;
use App\Pipeline\LogEntry\Filter\StatusCodeFilter;
use App\Pipeline\LogEntry\LogFilterPipeline;
use App\Pipeline\LogEntry\LogFilterPipelineInterface;

class LogEntryFactory
{
    /**
     * Creates a new LogFilterPipeline instance.
     *
     * @return LogFilterPipeline
     */
    public function createLogFilterPipeline(LogCountRequestTransfer $requestTransfer): LogFilterPipelineInterface
    {
        return new LogFilterPipeline([
            new ServiceNameFilter($requestTransfer),
            new StartDateFilter($requestTransfer),
            new EndDateFilter($requestTransfer),
            new StatusCodeFilter($requestTransfer),
        ]);
    }
}
