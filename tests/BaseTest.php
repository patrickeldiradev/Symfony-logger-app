<?php

namespace App\Tests;

use App\Entity\LogEntry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

/**
 * Class BaseTest
 * @package App\Tests
 *
 * Base test class to set up the environment for testing.
 */
abstract class BaseTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;

    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $entityManager;

    /**
     * Sets up the environment before each test.
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $container = self::getContainer();

        $this->entityManager = $container->get(EntityManagerInterface::class);

        // Ensure schema creation
        $this->createSchema();

        $this->insertTestData();
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
            // Ignore errors if schema does not exist
        }

        $schemaTool->createSchema($metadata);
    }

    /**
     * Cleans up the environment after each test.
     */
    protected function tearDown(): void
    {
        $this->entityManager->close();
        parent::tearDown();
    }


    /**
     * @return void
     * @throws \Exception
     */
    private function insertTestData(): void
    {
        $filePath = dirname(__DIR__) . '/tests/__data/logs.json';

        if (!file_exists($filePath)) {
            throw new \Exception("File not found: $filePath");
        }

        $jsonData = file_get_contents($filePath);
        $logEntries = json_decode($jsonData, true);

        foreach ($logEntries as $logEntry) {

            $log = new LogEntry();
            $log->setUri($logEntry['uri']);
            $log->setHttpVersion($logEntry['httpVersion']);
            $log->setHttpMethod($logEntry['httpMethod']);
            $log->setStatusCode($logEntry['statusCode']);
            $log->setLinePosition($logEntry['linePosition']);
            $log->setTimestamp(new \DateTime($logEntry['timestamp']));
            $log->setServiceName($logEntry['serviceName']);

            $this->entityManager->persist($log);
        }

        $this->entityManager->flush();
    }
}