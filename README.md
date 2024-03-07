# FizzBuzz

## Setup

Before creating the Laravel project, make sure that your local machine has [Docker](https://docs.docker.com/get-docker/)
installed.

1. Run the command `make env`.
2. Open the `.env`-file and adjust the variables if necessary. The following variables are particularly important:
    - `APP_PORT=8080`
    - `WWWGROUP=1000`
    - `WWWUSER=1000`
3. Run the command `make setup`.
4. Enter the url `localhost:<APP_PORT>` in your browser and you will see the welcome page.

### Alternative Setup

Before creating the Laravel project, make sure that your local machine has __PHP 8.3__ and Composer installed.

1. Run the command `composer install`.
2. Once the project has been created, start Laravel's local development server using Laravel Artisan's serve
   command: `php artisan serve`. In case of trouble try: `php artisan serve --host your_server_ip --port your_port`.
3. Enter the url `localhost:8000` in your browser and you will see the welcome page.

## Execute FizzBuzz

Enter the url in your browser and you will see the default page:

    localhost:8080/fizzbuzz

Maybe you have to change the PORT (depending on your settings).

You can also execute the FizzBuzz coding challenge as a command:

    make fizzbuzz

## Commands

| What                                       | Command               |
|--------------------------------------------|-----------------------|
| Composer install                           | `make vendor-install` |
| Composer update                            | `make vendor-update`  |
| Docker setup                               | `make setup`          |
| Docker start                               | `make docker-start`   |
| Docker stop                                | `make docker-stop`    |
| Docker Bash (enter container and run bash) | `make docker-bash`    |
| PHPStan                                    | `make static`         |
| Tests (unit, feature, integration)         | `make tests`          |