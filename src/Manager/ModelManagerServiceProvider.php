<?php
namespace ANavallaSuiza\Laravel\Database\Manager;

use Illuminate\Support\ServiceProvider;
use ANavallaSuiza\Laravel\Database\Manager\Eloquent\ModelManager;

class ModelManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager', 'ANavallaSuiza\Laravel\Database\Manager\Eloquent\ModelManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager'];
    }
}
