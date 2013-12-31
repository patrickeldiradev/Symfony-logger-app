<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

class LogCountRequestTransfer
{
    private ?array $serviceNames = null;

    private ?string $startDate = null;
    private ?string $endDate = null;

    private ?int $statusCode = null;

    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    public function setServiceNames(?array $serviceNames): void
    {
        $this->serviceNames = $serviceNames;
    }

    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function setStatusCode(?int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }
}