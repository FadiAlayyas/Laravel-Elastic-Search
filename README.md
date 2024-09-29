# Laravel & ElasticSearch

A Laravel-based article management application that utilizes Elasticsearch for powerful search capabilities. The system supports searchable articles using Elasticsearch in the generic way for adding a new model with real-time indexing .

## How It Works

Application Setup : The project is set up using Docker, which means all the services (like the web server, database, and Elasticsearch) run in isolated container. This allows to work in an environment that closely resembles production without needing to install all the dependencies locally .

Using Elasticsearch :

When a new article is created, it is indexed in Elasticsearch. This allows users to search for articles quickly and efficiently.
Whenever an article is updated, the old index is deleted, and a new one is created with the updated information.
If an article is deleted, its index is also removed from Elasticsearch, ensuring that search results are always current.
Real-time Indexing: Thanks to the integration with Elasticsearch, changes made to articles are reflected in real-time. This means that users can see their changes immediately when searching for articles.


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