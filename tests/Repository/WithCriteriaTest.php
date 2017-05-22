<?php

namespace Database\Tests\Repository;

use Ablunier\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria;
use Database\Tests\TestBase;

class WithCriteriaTest extends TestBase
{
    /** @var Ablunier\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new WithCriteria(['user']);
    }

    public function test_implements_criteria_interface()
    {
        $this->assertInstanceOf('Ablunier\Laravel\Database\Contracts\Repository\Criteria', $this->sut);
    }

    public function test_applies_with()
    {
        $repositoryMock = $this->mock('Ablunier\Laravel\Database\Repository\Eloquent\Repository');

        $eloquentBuilder = $this->sut->apply($this->app->make('Database\Tests\Models\Post'), $repositoryMock);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $eloquentBuilder);

        $eagerLoads = $eloquentBuilder->getEagerLoads();

        $this->assertArrayHasKey('user', $eagerLoads);
    }
}
