<?php

namespace App\Entity;

use App\Repository\LogEntry\LogEntryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogEntryRepository::class)]
#[ORM\Table(name: "log_entries")]
#[ORM\Index(name: "service_name_idx", columns: ["service_name"])]
#[ORM\Index(name: "status_code_idx", columns: ["status_code"])]
#[ORM\Index(name: "timestamp_idx", columns: ["timestamp"])]
class LogEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $serviceName = null;

    #[ORM\Column(type: "datetime", nullable: true)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $httpMethod = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $uri = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    private ?string $httpVersion = null;

    #[ORM\Column(type: "integer", nullable: true)]
    private ?int $statusCode = null;

    #[ORM\Column(type: "bigint", nullable: true)]
    private ?int $linePosition = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getServiceName(): ?string
    {
        return $this->serviceName;
    }

    /**
     * @param string|null $serviceName
     */
    public function setServiceName(?string $serviceName): void
    {
        $this->serviceName = $serviceName;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTimeInterface|null $timestamp
     */
    public function setTimestamp(?\DateTimeInterface $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string|null
     */
    public function getHttpMethod(): ?string
    {
        return $this->httpMethod;
    }

    /**
     * @param string|null $httpMethod
     */
    public function setHttpMethod(?string $httpMethod): void
    {
        $this->httpMethod = $httpMethod;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param string|null $uri
     */
    public function setUri(?string $uri): void
    {
        $this->uri = $uri;
    }

    /**
     * @return string|null
     */
    public function getHttpVersion(): ?string
    {
        return $this->httpVersion;
    }

    /**
     * @param string|null $httpVersion
     */
    public function setHttpVersion(?string $httpVersion): void
    {
        $this->httpVersion = $httpVersion;
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
     * @return int|null
     */
    public function getLinePosition(): ?int
    {
        return $this->linePosition;
    }

    /**
     * @param int|null $linePosition
     */
    public function setLinePosition(?int $linePosition): void
    {
        $this->linePosition = $linePosition;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
