<?php

namespace App\DTO\LogEntry;

use App\DTO\AbstractTransfer;
use App\Validator\Constraints\HttpStatusCode;
use Symfony\Component\Validator\Constraints as Assert;

class LogCountRequestTransfer extends AbstractTransfer
{
    /**
     * @var array<string>|null
     */
    #[Assert\All([
        new Assert\NotBlank(),
        new Assert\Length(max: 100),
    ])]
    private ?array $serviceNames = null;

    #[
        Assert\Regex(
            pattern: '/^\d{4}-\d{2}-\d{2}$/',
            message: 'The start date must be in the format YYYY-MM-DD.'
        ),
        Assert\Expression(
            "this.getStartDate() === null || this.getEndDate() === null || this.getStartDate() <= this.getEndDate()",
            message: "The start date must be before or equal to the end date."
        )
    ]
    private ?string $startDate = null;

    #[
        Assert\Regex(
            pattern: '/^\d{4}-\d{2}-\d{2}$/',
            message: 'The start date must be in the format YYYY-MM-DD.'
        ),
        Assert\Expression(
            "this.getStartDate() === null || this.getEndDate() === null || this.getEndDate() >= this.getStartDate()",
            message: "The end date must be after or equal to the start date."
        )
    ]
    private ?string $endDate = null;

    #[HttpStatusCode]
    private ?int $statusCode = null;

    /**
     * @return array<string>|null
     */
    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    /**
     * @param array<string>|null $serviceNames
     */
    public function setServiceNames(?array $serviceNames): void
    {
        $this->serviceNames = $serviceNames;
    }

    /**
     * @return string|null
     */
    public function getStartDate(): ?string
    {
        return $this->startDate;
    }

    /**
     * @param string|null $startDate
     */
    public function setStartDate(?string $startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return string|null
     */
    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    /**
     * @param string|null $endDate
     */
    public function setEndDate(?string $endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return int|null
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * @param int|null $statusCode
     */
    public function setStatusCode(?int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param array<mixed> $data
     * @return $this
     */
    public function fromArray(array $data): self
    {
        $this->setServiceNames($data['serviceNames'] ?? null);
        $this->setStartDate($data['startDate'] ?? null);
        $this->setEndDate($data['endDate'] ?? null);
        $this->setStatusCode($data['statusCode'] ?? null);

        return $this;
    }
}
