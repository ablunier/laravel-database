<?php
namespace Database\Tests\Manager;

use Database\Tests\TestBase;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Cache;
use ANavallaSuiza\Laravel\Database\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Collection;
use Mockery\Mock;

class CacheTest extends TestBase
{
    /** @var ANavallaSuiza\Laravel\Database\Repository\Eloquent\Cache */
    protected $sut;
    /** @var  Mock */
    protected $repositoryMock;
    /** @var  Mock */
    protected $cacheMock;

    public function setUp()
    {
        parent::setUp();

        $this->repositoryMock = $this->mock('ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository');
        $this->cacheMock = $this->mock('Illuminate\Contracts\Cache\Repository');

        $this->sut = new Cache($this->repositoryMock, $this->cacheMock);
    }

    public function test_implements_cache_interface()
    {
        $this->assertInstanceOf('ANavallaSuiza\Laravel\Database\Contracts\Repository\Cache', $this->sut);
    }

    public function test_throws_repository_exception_when_method_does_not_exist()
    {
        $this->setExpectedException(RepositoryException::class);

        $this->sut->whateverRepoMethod();
    }

    public function test_skips_cache()
    {
        $this->repositoryMock->shouldReceive('all')->andReturn(new Collection);

        $result = $this->sut->skipCache(true)->all();

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    public function test_refreshes_cache()
    {
        $modelMock = $this->mock('ANavallaSuiza\Laravel\Database\Contracts\Repository\HasCache');
        $modelMock->shouldReceive('cacheLifetime')->andReturn(10);

        $this->repositoryMock->shouldReceive('getModel')->andReturn($modelMock);
        $this->repositoryMock->shouldReceive('all')->andReturn(new Collection);

        $this->cacheMock->shouldReceive('forget');
        $this->cacheMock->shouldReceive('remember')->andReturn(new Collection);

        $result = $this->sut->refreshCache()->all();

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }
}
