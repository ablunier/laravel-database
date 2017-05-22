<?php
namespace Database\Tests\Manager;

use Database\Tests\TestBase;

class ModelManagerTest extends TestBase
{
    /** @var Ablunier\Laravel\Database\Manager\Eloquent\ModelManager */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = $this->app->make('Ablunier\Laravel\Database\Manager\Eloquent\ModelManager');
    }

    public function test_implements_manager_interface()
    {
        $this->assertInstanceOf('Ablunier\Laravel\Database\Contracts\Manager\ModelManager', $this->sut);
    }

    public function test_returns_model_instance()
    {
        $modelInstance = $this->sut->getModelInstance('Database\Tests\Models\User');

        $this->assertInstanceOf('Database\Tests\Models\User', $modelInstance);
    }

    public function test_throws_exception_when_not_eloquent_model()
    {
        $this->setExpectedException(\Exception::class);

        $this->sut->getModelInstance('Database\Tests\Models\WrongModel');
    }

    public function test_returns_model_default_repository()
    {
        $repository = $this->sut->getRepository('Database\Tests\Models\User');

        $this->assertInstanceOf('Ablunier\Laravel\Database\Repository\Eloquent\Repository', $repository);
    }

    public function test_returns_model_custom_repository()
    {
        $repository = $this->sut->getRepository('Database\Tests\Models\Post');

        $this->assertInstanceOf('Database\Tests\Models\Repositories\PostRepository', $repository);
    }

    public function test_returns_model_cache_repository()
    {
        $repository = $this->sut->getRepository('Database\Tests\Models\Country');

        $this->assertInstanceOf('Ablunier\Laravel\Database\Repository\Eloquent\Cache', $repository);
    }

    public function test_throws_exception_when_custom_repository_is_not_extending_default()
    {
        $this->setExpectedException(\Exception::class);

        $repository = $this->sut->getRepository('Database\Tests\Models\Text');
    }

    public function test_returns_model_abstraction_layer()
    {
        $repository = $this->sut->getAbstractionLayer('Database\Tests\Models\User');

        $this->assertInstanceOf('Ablunier\Laravel\Database\Dbal\Eloquent\AbstractionLayer', $repository);
    }
}
