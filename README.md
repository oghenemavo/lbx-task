# LBX Task

## Installation

LBX Task requires at least php 8 to run.

This project is powered by the Laravel Framework

Install the dependencies and devDependencies and start the server.

```sh
composer install
php artisan serve
```
Run Database Migrations
```sh
php artisan migrate
```

Start Background task

```sh
php artisan queue:listen --timeout=0
```

