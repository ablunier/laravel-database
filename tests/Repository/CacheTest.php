<?php

namespace Database\Tests\Manager;

use Ablunier\Laravel\Database\Repository\Eloquent\Cache;
use Ablunier\Laravel\Database\Repository\Exceptions\RepositoryException;
use Database\Tests\TestBase;
use Illuminate\Support\Collection;
use Mockery\Mock;

class CacheTest extends TestBase
{
    /** @var Ablunier\Laravel\Database\Repository\Eloquent\Cache */
    protected $sut;
    /** @var Mock */
    protected $repositoryMock;
    /** @var Mock */
    protected $cacheMock;

    public function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->mock('Ablunier\Laravel\Database\Contracts\Repository\Repository');
        $this->cacheMock = $this->mock('Illuminate\Contracts\Cache\Repository');

        $this->sut = new Cache($this->repositoryMock, $this->cacheMock);
    }

    public function test_implements_cache_interface()
    {
        $this->assertInstanceOf('Ablunier\Laravel\Database\Contracts\Repository\Cache', $this->sut);
    }

    public function test_throws_repository_exception_when_method_does_not_exist()
    {
        $this->setExpectedException(RepositoryException::class);

        $this->sut->whateverRepoMethod();
    }

    public function test_skips_cache()
    {
        $this->repositoryMock->shouldReceive('all')->andReturn(new Collection());

        $result = $this->sut->skipCache(true)->all();

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    public function test_refreshes_cache()
    {
        $modelMock = $this->mock('Ablunier\Laravel\Database\Contracts\Repository\HasCache');
        $modelMock->shouldReceive('cacheLifetime')->andReturn(10);

        $this->repositoryMock->shouldReceive('getModel')->andReturn($modelMock);
        $this->repositoryMock->shouldReceive('all')->andReturn(new Collection());

        $this->cacheMock->shouldReceive('forget');
        $this->cacheMock->shouldReceive('remember')->andReturn(new Collection());

        $result = $this->sut->refreshCache()->all();

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }
}
