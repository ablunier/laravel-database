<?php
namespace Database\Tests\Manager;

use Database\Tests\TestBase;

class SchemaUpdateTest extends TestBase
{
    /** @var ANavallaSuiza\Laravel\Database\Console\Commands\SchemaUpdate */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = $this->app->make('ANavallaSuiza\Laravel\Database\Console\Commands\SchemaUpdate');
    }

    public function test_extends_illuminate_command()
    {
        $this->assertInstanceOf('Illuminate\Console\Command', $this->sut);
    }

    public function test_handles_schema_updates()
    {

    }

    public function test_handles_and_executes_schema_updates()
    {

    }
}
