<?php

namespace App\Tests\Feature;

use App\Tests\BaseTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoggerControllerTest
 *
 * Tests for the LoggerController.
 */
class LoggerControllerTest extends BaseTest
{
    /**
     * Set up the environment before each test.
     *
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test the /count endpoint for a correct response.
     *
     * @return void
     */
    public function test_count_action_returns_correct_response(): void
    {
        // Arrange
        // Act
        $this->client->request('GET', '/count');
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_OK, $status_code);
        $this->assertJson($response_content);
        $this->assertArrayHasKey('count', $response_data);
        $this->assertEquals(20, $response_data['count']);
    }

    /**
     * Test the /count endpoint handles extra data.
     *
     * @return void
     */
    public function test_count_action_handles_extra_data(): void
    {
        // Arrange
        $request_data = [
            'serviceNames' => ['USER-SERVICE', 'INVOICE-SERVICE'],
            'statusCode' => 201,
            'startDate' => '2018-08-18',
            'endDate' => '2018-08-19',
        ];

        // Act
        $this->client->request('GET', '/count', $request_data);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_OK, $status_code);
        $this->assertEquals(5, $response_data['count']);
    }

    /**
     * Test the /count endpoint with an invalid startDate format.
     *
     * @return void
     */
    public function test_count_action_invalid_start_date_format_validation(): void
    {
        // Arrange
        $invalid_date_format = '2023/08/18'; // Invalid format

        // Act
        $this->client->request('GET', '/count', ['startDate' => $invalid_date_format]);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status_code);
        $this->assertArrayHasKey('errors', $response_data);
    }

    /**
     * Test the /count endpoint with an invalid endDate format.
     *
     * @return void
     */
    public function test_count_action_invalid_end_date_format_validation(): void
    {
        // Arrange
        $invalid_date_format = '18-08-2023'; // Invalid format

        // Act
        $this->client->request('GET', '/count', ['endDate' => $invalid_date_format]);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status_code);
        $this->assertArrayHasKey('errors', $response_data);
    }

    /**
     * Test the /count endpoint with startDate after endDate.
     *
     * @return void
     */
    public function test_count_action_start_date_after_end_date_validation(): void
    {
        // Arrange
        $start_date = '2023-08-20';
        $end_date = '2023-08-18'; // startDate is after endDate

        // Act
        $this->client->request('GET', '/count', ['startDate' => $start_date, 'endDate' => $end_date]);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status_code);
        $this->assertArrayHasKey('errors', $response_data);
    }

    /**
     * Test the /count endpoint with invalid serviceNames length.
     *
     * @return void
     */
    public function test_count_action_invalid_service_names_length_validation(): void
    {
        // Arrange
        $request_data = [
            'serviceNames' => [
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, qu'
            ],
        ];

        // Act
        $this->client->request('GET', '/count', $request_data);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status_code);
        $this->assertArrayHasKey('errors', $response_data);
    }

    /**
     * Test the /count endpoint with an invalid status code.
     *
     * @return void
     */
    public function test_count_action_invalid_status_code_validation(): void
    {
        // Arrange
        $request_data = [
            'statusCode' => 999, // Invalid status code
        ];

        // Act
        $this->client->request('GET', '/count', $request_data);
        $response = $this->client->getResponse();
        $response_content = $response->getContent();
        $response_data = json_decode((string) $response_content, true);
        $status_code = $response->getStatusCode();

        // Assert
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $status_code);
        $this->assertArrayHasKey('errors', $response_data);
    }
}