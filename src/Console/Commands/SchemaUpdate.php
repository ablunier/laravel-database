<?php
namespace ANavallaSuiza\Laravel\Database\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel as Console;
use Schema;
use DB;
use Doctrine\DBAL\Schema\Comparator;

class SchemaUpdate extends Command
{
    const CONNECTION_NAME = 'schema-update';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:schema-update {--force : Force execute queries}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates database schema with any migration changes';

    /**
     *
     * @var Application
     */
    protected $app;

    /**
     *
     * @var Console
     */
    protected $artisan;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Application $app, Console $artisan)
    {
        parent::__construct();

        $this->app = $app;
        $this->artisan = $artisan;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Retrieving schema differences...'.PHP_EOL);

        $this->createInMemoryDatabase();

        $defaultSm = $this->getSchemaManager();
        $inMemorySm = $this->getSchemaManager(self::CONNECTION_NAME);

        $fromSchema = $defaultSm->createSchema();
        $toSchema = $inMemorySm->createSchema();

        $comparator = new Comparator();
        $schemaDiff = $comparator->compare($fromSchema, $toSchema);

        $diffStatements = $schemaDiff->toSql($this->getDatabasePlatform());

        $this->info('Statements that will be executed:'.PHP_EOL);

        $this->info(print_r($diffStatements, true));

        if ($this->option('force')) {
            DB::transaction(function () use ($diffStatements) {
                foreach ($diffStatements as $statement) {
                    DB::statement($statement);
                }
            });
        } else {
            $this->info('To execute diff statements use the --force option');
        }
    }

    protected function createInMemoryDatabase()
    {
        $this->app['config']->set('database.connections.'.self::CONNECTION_NAME, [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => ''
        ]);

        // Makes sure the migrations table is created
        $this->artisan->call('migrate', [
            '--database'     => self::CONNECTION_NAME,
        ]);

        // We empty all tables
        $this->artisan->call('migrate:reset');

        // Migrate
        $this->artisan->call('migrate', [
            '--path'     => self::CONNECTION_NAME,
        ]);
    }

    protected function getSchemaManager($connection = null)
    {
        if (isset($connection)) {
            $connection = Schema::connection($connection)->getConnection();
        } else {
            $connection = Schema::getConnection();
        }

        return $connection->getDoctrineSchemaManager();
    }

    protected function getDatabasePlatform($connection = null)
    {
        if (isset($connection)) {
            $connection = Schema::connection($connection)->getConnection();
        } else {
            $connection = Schema::getConnection();
        }

        return $connection->getDoctrineConnection()->getDatabasePlatform();
    }
}
