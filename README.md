# Symfony Looger App

LogImporter is a PHP application designed to import and process log files, saving the log entries into a database. 

## Installation

To install and run this project, follow these steps:

1. Clone the repository to your local machine:

    ```bash
    git clone git@github.com:ahmedelattar73/symfony_logger_app.git
    ```

2. Navigate to the project directory:

    ```bash
    cd symfony_logger_app
    ```

3. Install docker compose.

4. Build and run docker containers using Docker Compose:

    ```bash
    docker-compose up --build -d
    ```
   
3. Install dependencies:

    ```bash
    docker-compose exec app composer install
    ```

8. Run database migrations:

    ```bash
    docker-compose exec app php bin/console doctrine:migrations:migrate
    ```

10. Run the scheduler:

    ```bash
      docker-compose exec app php bin/console messenger:consume scheduler_watchlogs -vv
    ```

### Run Tests

0. To get the logs count, send a GET request to the `/count` endpoint with the following JSON payload:

    ```bash
    docker-compose exec app bin/phpunit
    ```

### API Documentation

#### GET /count

This endpoint retrieves the count of log entries that match the specified criteria.

#### Request

**URL**: `http://localhost:8000/count`

**Method**: `GET`

**Query Parameters**: (All parameters are optional)

- `serviceNames[]`: An array of service names to filter by. Multiple values can be specified.
   - Example: `serviceNames[0]=USER-SERVICE&serviceNames[1]=INVOICE-SERVICE`
- `startDate`: The start date for the log entries in `YYYY-MM-DD` format.
   - Example: `startDate=2018-08-17`
- `endDate`: The end date for the log entries in `YYYY-MM-DD` format.
   - Example: `endDate=2018-08-20`
- `statusCode`: The HTTP status code to filter by.
   - Example: `statusCode=201`

#### Response

```json
{
   "count": 0
}
