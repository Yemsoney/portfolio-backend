<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
{
    "build": {
      "command": "composer install && php artisan migrate --force"
    },
    "start": {
      "command": "php artisan serve --host=0.0.0.0 --port=$PORT"
    }
  }
    "scripts": {
      "post-install-cmd": [
        "php artisan key:generate",
        "php artisan migrate --force"
      ],
      "post-update-cmd": [
        "php artisan key:generate",
        "php artisan migrate --force"
      ]
    },  