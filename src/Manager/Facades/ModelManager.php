<?php
namespace ANavallaSuiza\Laravel\Database\Manager\Facades;

use Illuminate\Support\Facades\Facade;

class ModelManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager';
    }
}
