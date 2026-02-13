# Music Freshman Report

## Goal
Fetch data from music entrance exams results and generate a web app to display the results by instrument.

## Technologies

| Technology | Version |
|------------|---------|
| PHP        | 8.3     |
| Laravel    | 12      |
| pdftotext  | 23.13   |

## Features
* CLI command to save data from the entrance exam results.
* CLI command to update data from the storage.
* API to provide data for the web app.
* Frontend to display the results.

## Dataset

Entrance exams from 2016-2026.

## How to run

1. Clone the repository.
2. Install dependencies:
   ```bash
   composer install
   ```
3. Set up the environment:
   ```bash
    cp .env.example .env
    ```
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Fetch and save data:
   ```bash
   php artisan app:import {json_path=data.json}
    ```
6. Run tests:
   ```bash
   php artisan test
   ```
7. Start the development server:
   ```bash
    php artisan serve
    ```


