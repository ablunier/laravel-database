<?php
namespace Ablunier\Laravel\Database\Manager\Facades;

use Illuminate\Support\Facades\Facade;

class ModelManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Ablunier\Laravel\Database\Contracts\Manager\ModelManager';
    }
}
