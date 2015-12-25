<?php
namespace ANavallaSuiza\Laravel\Database\Manager;

use Illuminate\Support\ServiceProvider;
use ANavallaSuiza\Laravel\Database\Manager\Eloquent\ModelManager;
use ANavallaSuiza\Laravel\Database\Console\Commands\SchemaUpdate;

class ModelManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/laravel-database.php' => config_path('laravel-database.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/laravel-database.php', 'laravel-database');

        $this->app->bind('ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager', function ($app) {
            return new ModelManager($app);
        });

        $this->registerCommands();
    }

    protected function registerCommands()
    {
        $this->app->singleton('command.database.schema-update', function ($app) {
            $console = $app->make('Illuminate\Contracts\Console\Kernel');

            return new SchemaUpdate($app, $console);
        });

        $this->commands('command.database.schema-update');
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'ANavallaSuiza\Laravel\Database\Contracts\Manager\ModelManager',
            'command.database.schema-update'
        ];
    }
}
