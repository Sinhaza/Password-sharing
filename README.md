# Password Sharing

A Laravel application for sharing passwords and sensitive information safely.  
This project leverages Docker for easy setup and includes feature tests to ensure reliability.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Running Tests](#running-tests)
- [Contributing](#contributing)
- [License](#license)

## Features

- Secure password sharing via unique, time-limited links
- Laravel 12 backend
- VUE.js 3 front-end
- Dockerized environment (PHP, Nginx, MySQL)
- Feature and unit tests with PHPUnit

## Requirements

- [Docker](https://www.docker.com/get-started) and [Docker Compose](https://docs.docker.com/compose/)
- (Optional) [Composer](https://getcomposer.org/) and [Node.js](https://nodejs.org/) if running outside Docker

## Installation

Follow these steps to set up the project locally:

1. **Clone the repository**
    ```
    git clone https://github.com/Sinhaza/Password-sharing.git
    cd Password-sharing
    ```

2. **Copy the environment file**
    ```
    cp .env.example .env
    ```

3. **Start Docker containers**
    ```
    vendor/bin/sail up -d
    ```

4. **Install dependencies**
    ```
    vendor/bin/sail composer install
    vendor/bin/sail npm install
    vendor/bin/sail npm run dev
    ```

5. **Generate application key**
    ```
    vendor/bin/sail php artisan key:generate
    ```

6. **Run migrations and seeders**
    ```
    vendor/bin/sail php artisan migrate --seed
    ```
7. **Run the application**
    ```
    vendor/bin/sail npm run dev 
    ```
    ```
    vendor/bin/sail php artisan serve 
    ```

8. **Access the application**

    Visit [http://localhost/](http://localhost/) in your browser.

## Usage

- Use the web interface to create and share secure password links.
- Shared links are time-limited and/or self-destruct after viewing, ensuring sensitive information is not stored longer than necessary.

    In order to run the automatic deletion of passwords on expired times, run the following
    ```
    vendor/bin/sail php artisan schedule:run
    ```

## Running Tests

To run the feature and unit tests inside Docker, use:
```
    vendor/bin/sail php artisan test
```