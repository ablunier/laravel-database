<?php
namespace Database\Tests\Repository;

use Database\Tests\TestBase;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria;

class WithCriteriaTest extends TestBase
{
    /** @var ANavallaSuiza\Laravel\Database\Repository\Eloquent\Criteria\WithCriteria */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new WithCriteria(['user']);
    }

    public function test_implements_criteria_interface()
    {
        $this->assertInstanceOf('ANavallaSuiza\Laravel\Database\Contracts\Repository\Criteria', $this->sut);
    }

    public function test_applies_with()
    {
        $repositoryMock = $this->mock('ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository');

        $eloquentBuilder = $this->sut->apply($this->app->make('Database\Tests\Models\Post'), $repositoryMock);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Builder', $eloquentBuilder);

        $eagerLoads = $eloquentBuilder->getEagerLoads();
        $relationNames = array_keys($eagerLoads);

        $this->assertContains('user', $relationNames);
    }
}
