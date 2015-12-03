<?php
namespace Database\Tests;

use Orchestra\Testbench\TestCase;
use FilesystemIterator;
use DB;
use Mockery;

abstract class TestBase extends TestCase
{
    const MIGRATIONS_PATH = 'tests/migrations';

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();
        $this->resetDatabase();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__.'/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'    => ''
        ]);
    }

    private function resetDatabase()
    {
        $artisan = $this->app->make('Illuminate\Contracts\Console\Kernel');

        // Makes sure the migrations table is created
        $artisan->call('migrate', [
            '--path'     => self::MIGRATIONS_PATH,
        ]);

        // We empty all tables
        $artisan->call('migrate:reset');

        // Migrate
        $artisan->call('migrate', [
            '--path'     => self::MIGRATIONS_PATH,
        ]);
    }

    protected function getPackageProviders($app)
    {
        return ['ANavallaSuiza\Laravel\Database\Manager\ModelManagerServiceProvider'];
    }

    public function mock($className)
    {
        return Mockery::mock($className);
    }

    /**
     * Test running migration.
     *
     * @test
     */
    public function test_running_migration()
    {
        $migrations = DB::select('SELECT * FROM migrations');

        $fi = new FilesystemIterator(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR .self::MIGRATIONS_PATH, FilesystemIterator::SKIP_DOTS);

        $this->assertCount(iterator_count($fi), $migrations);
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
