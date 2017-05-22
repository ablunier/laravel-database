# Laravel Database [![Build Status](https://travis-ci.org/ablunier/laravel-database.svg?branch=master)](https://travis-ci.org/ablunier/laravel-database) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ablunier/laravel-database/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ablunier/laravel-database/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/ablunier/laravel-database/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/ablunier/laravel-database/?branch=master)

This package provides some utilities and patterns to work with Laravel databases


> **Note:** This package is in active development and NOT ready for production.

### Features
* Automatic default and extendable repository pattern.
* Cache system over repository pattern.
* Model abstraction layer.

### Requirements
* PHP 5.5 or higher.
* Laravel 5.

## Installation

Require this package with composer:
```
composer require ablunier/laravel-database
```

After updating composer, add the ServiceProvider and Facade (optional) to the app.php config file:
```php
// config/app.php

'providers' => [
    '...',
    Ablunier\Laravel\Database\Manager\ModelManagerServiceProvider::class,
];

'aliases' => [
    '...',
    'ModelManager' => Ablunier\Laravel\Database\Manager\Facades\ModelManager::class,
];
```

Copy the package config to your local config with the publish command:
```
php artisan vendor:publish
```

## Usage

### Repository pattern
```php
<?php
namespace App\Http\Controllers;

use ModelManager;
use View;

class ExampleController extends Controller
{
    public function index()
    {
        $repo = ModelManager::getRepository('App\User');

        $users = $repo->all();

        View::make('users.index', [
            'users' => $users
        ]);
    }
}
```

```php
<?php
namespace App\Http\Controllers;

use Ablunier\Laravel\Database\Contracts\Manager\ModelManager;
use View;

class ExampleController extends Controller
{
    protected $mm;

    public function __construct(ModelManager $mm)
    {
        $this->mm = $mm;
    }

    public function index()
    {
        $repo = $this->mm->getRepository('App\User');

        $users = $repo->all();

        View::make('users.index', [
            'users' => $users
        ]);
    }
}
```

### Cache

### Abstraction layer

## Documentation

Visit the [wiki](https://github.com/ablunier/laravel-database/wiki) for more information.

## License

This software is published under the MIT License
