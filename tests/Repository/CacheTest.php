<?php
namespace Database\Tests\Manager;

use Database\Tests\TestBase;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Cache;

class CacheTest extends TestBase
{
    /** @var ANavallaSuiza\Laravel\Database\Repository\Eloquent\Cache */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $repository = new Repository($this->app->make('Database\Tests\Models\User'));
        $this->sut = new Cache($repository, $this->app['cache.store']);
    }

    public function test_implements_cache_interface()
    {
        $this->assertInstanceOf('ANavallaSuiza\Laravel\Database\Contracts\Repository\Cache', $this->sut);
    }

    public function test_skips_cache()
    {
        $results = $this->sut->skipCache(true)->all();
    }

    public function test_refreshes_cache()
    {
        $results = $this->sut->refreshCache()->all();
    }
}
