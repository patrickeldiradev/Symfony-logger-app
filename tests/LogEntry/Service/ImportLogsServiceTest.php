<?php

namespace App\Tests\LogEntry\Service;

use App\Entity\LogEntry;
use App\Service\LogEntry\ImportLogsServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Command\Command;

class ImportLogsServiceTest extends KernelTestCase
{
    private $service;
    private $entityManager;

    /**
     * Sets up the environment before each test.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();

        $container = static::getContainer();
        $this->service = $container->get(ImportLogsServiceInterface::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);

        $this->createSchema();
    }

    /**
     * Test the execute method when the file does not exist.
     *
     * @return void
     */
    public function test_execute_file_not_exists(): void
    {
        // Act
        $logFilePath = '/invalid/path/to/logfile.log';

        $result = $this->service->execute($logFilePath);

        $logEntries = $this->entityManager
            ->getRepository(LogEntry::class)
            ->findAll();

        // Assert
        $this->assertEquals(Command::FAILURE, $result);
        $this->assertCount(0, $logEntries);
    }

    /**
     * Test the execute method when the file is empty.
     *
     * @return void
     */
    public function test_Execute_success(): void
    {
        // Ac
        $logFilePath = dirname(__DIR__) . '/_data/logs.log';
        $result = $this->service->execute($logFilePath);

        // Assert
        $this->assertEquals(Command::SUCCESS, $result);

        $logEntries = $this->entityManager
            ->getRepository(LogEntry::class)
            ->findAll();

        $this->assertCount(20, $logEntries);
    }


    /**
     * Creates the database schema.
     */
    private function createSchema(): void
    {
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        try {
            $schemaTool->dropSchema($metadata);
        } catch (\Exception $e) {
        }

        $schemaTool->createSchema($metadata);
    }
}
