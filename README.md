# Symfony Looger App

LogImporter is a PHP application designed to import and process log files, saving the log entries into a database. 

## Installation

To install and run this project, follow these steps:

1. Clone the repository to your local machine:

    ```bash
    git git@github.com:ahmedelattar73/symfony_logger_app.git
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


### Request Details

To get the logs count, send a GET request to the `/count` endpoint with the following JSON payload:

```json
{
   "count": 0
}
```

### Run Tests

To get the logs count, send a GET request to the `/count` endpoint with the following JSON payload:

```json
docker-compose exec app bin/phpunit
```