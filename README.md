# Laravel Database

This package provides an easy repository pattern for Laravel


> **Note:** This package is in active development and NOT ready for production.

### Requirements
* PHP 5.4 or higher.
* Laravel 5.

## Installation

```json
"ablunier/laravel-database": "dev-master"
```

```php
// config/app.php

'providers' => [
    '...',
    'ANavallaSuiza\Laravel\Database\Manager\ModelManagerServiceProvider',
];

'aliases' => [
    '...',
    'ModelManager' => 'ANavallaSuiza\Laravel\Database\Manager\Facades\ModelManager',
];
```

## Example of usage

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
