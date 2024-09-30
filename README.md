# Laravel & ElasticSearch

This is an application for managing articles created in Laravel and enhanced with the power of Elasticsearch. The system enables search against articles in a generic way by means of Elasticsearch around the same process of enhancing a new model with its real time indexation .

## How It Works

Application Setup: 
The project is configured using Docker, that is how all the services like the web server, database and Elasticsearch are working in a separated container. That makes it possible to work in a setting which is as realistic without all the prerequisites being installed.

Using Elasticsearch:
Whenever a new article comes into being, it is indexed within the corresponding article. This makes it easier and faster for just about anyone to perform searches on the articles.

Every time an article is changed, there is no ordering of the old index but rather the old index is discarded and a new index is ordered containing only the pertinent information.

Once an article is marked and subsequently deleted, its relevant index is also deleted in Elasticsearch making sure that search query will not yield stale results.


## Table of Contents

- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Usage](#usage)

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **PHP 8.1 or higher**
- **Composer**
- **Docker** and **Docker Compose**
- **Laravel Sail** (included in the project)
- **Elasticsearch**
  
## Installation

Follow these steps to install the application:

1. **Clone the repository**:
    ```bash
    git clone <repository-url>
    cd <project-directory>
    ```

2. **Install the dependencies**:
    ```bash
    ./vendor/bin/sail composer install
    ```

3. **Copy the environment file**:
    ```bash
    cp .env.example .env
    ```

4. **Generate the application key**:
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

## Rebuilding Sail Images

Sometimes you may want to completely rebuild your Sail images to ensure all of the image's packages and software are up to date. You may accomplish this using the following commands:

1. **Stop and remove all containers and volumes**:
    ```bash
    docker compose down -v
    # or
    ./vendor/bin/sail down
    ```

2. **Rebuild the Sail images**:
    ```bash
    ./vendor/bin/sail build --no-cache
    ```

3. **Start the Sail environment**:
    ```bash
    ./vendor/bin/sail up -d
    ```

## Running the Application

After setting up the Sail environment, proceed with the following steps:

5. **Run the migrations**:
    ```bash
    ./vendor/bin/sail artisan migrate
    ```

6. **Seed the database**:
    ```bash
    ./vendor/bin/sail artisan db:seed --class=DatabaseSeeder
    ```

7. **If needed, refresh the database** (drop all tables, run migrations, and seed again):
    ```bash
    ./vendor/bin/sail artisan migrate:refresh --seed
    ```

8. **Reindex Elasticsearch**:
    ```bash
    ./vendor/bin/sail artisan search:reindex
    ```

9. **Optimize the application**:
    ```bash
    ./vendor/bin/sail artisan optimize
    ```

## Usage

Once the application is running, you can access it at `http://localhost`. You can create, update, delete, and search articles using the provided endpoints in your API.