<?php

namespace Database\Tests\Dbal;

use Ablunier\Laravel\Database\Dbal\Eloquent\AbstractionLayer;
use Database\Tests\TestBase;

class AbstractionLayerTest extends TestBase
{
    /** @var Ablunier\Laravel\Database\Dbal\Eloquent\AbstractionLayer */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new AbstractionLayer($this->app->make('Database\Tests\Models\User'));
    }

    public function test_implements_abstraction_layer_interface()
    {
        $this->assertInstanceOf('Ablunier\Laravel\Database\Contracts\Dbal\AbstractionLayer', $this->sut);
    }

    public function test_returns_model()
    {
        $modelInstance = $this->sut->getModel();

        $this->assertInstanceOf('Database\Tests\Models\User', $modelInstance);
    }

    public function test_returns_model_table_columns()
    {
        $columns = $this->sut->getTableColumns();

        $this->assertInternalType('array', $columns);
        $this->assertNotEmpty($columns);

        $this->assertArrayHasKey('id', $columns);
        $this->assertInstanceOf('Doctrine\DBAL\Schema\Column', $columns['id']);
    }

    public function test_returns_model_table_column()
    {
        $column = $this->sut->getTableColumn('id');

        $this->assertInstanceOf('Doctrine\DBAL\Schema\Column', $column);
    }

    public function test_throws_exception_when_column_not_exists()
    {
        $this->setExpectedException(\Exception::class);

        $this->sut->getTableColumn('whatever');
    }

    public function test_returns_model_attributes()
    {
        $attributes = $this->sut->getModelAttributes();

        $this->assertInternalType('array', $attributes);
        $this->assertNotEmpty($attributes);
        $this->assertContains('id', $attributes);
    }

    public function test_returns_model_table_foreign_keys()
    {
    }
}
