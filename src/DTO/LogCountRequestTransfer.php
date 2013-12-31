<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

class LogCountRequestTransfer
{
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

    #[Assert\Choice(
        choices: [
            100, 101, 102, 103, 200, 201, 202, 203, 204, 205, 206, 207, 208, 226,
            300, 301, 302, 303, 304, 305, 307, 308, 400, 401, 402, 403, 404, 405,
            406, 407, 408, 409, 410, 411, 412, 413, 414, 415, 416, 417, 418, 421,
            422, 423, 424, 426, 428, 429, 431, 451, 500, 501, 502, 503, 504, 505,
            506, 507, 508, 510, 511
        ],
        message: 'The status code must be a valid HTTP status code.'
    )]
    private ?int $statusCode = null;

    /**
     * @return array|null
     */
    public function getServiceNames(): ?array
    {
        return $this->serviceNames;
    }

    /**
     * @param array|null $serviceNames
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
}
