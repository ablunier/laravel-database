# Laravel Database [![Build Status](https://travis-ci.org/ablunier/laravel-database.svg?branch=master)](https://travis-ci.org/ablunier/laravel-database)

This package provides some utilities and patterns to work with Laravel databases


> **Note:** This package is in active development and NOT ready for production.

### Features
* Automatic default and extendable repository pattern.
* Cache system over repository pattern.
* Model abstraction layer.
* Schema update console command.

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
    ANavallaSuiza\Laravel\Database\Manager\ModelManagerServiceProvider::class,
];

'aliases' => [
    '...',
    'ModelManager' => ANavallaSuiza\Laravel\Database\Manager\Facades\ModelManager::class,
];
```

Copy the package config to your local config with the publish command:
```
php artisan vendor:publish
```

## Usage

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

use ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager;
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

## Documentation

Visit the [wiki](https://github.com/ablunier/laravel-database/wiki) for more information.

## License

This software is published under the MIT License
