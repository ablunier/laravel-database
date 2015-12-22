<?php
namespace Database\Tests\Manager;

use Database\Tests\TestBase;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;

class RepositoryTest extends TestBase
{
    /** @var ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository */
    protected $sut;

    public function setUp()
    {
        parent::setUp();

        $this->sut = new Repository($this->app->make('Database\Tests\Models\User'));
    }

    public function test_implements_repository_interface()
    {
        $this->assertInstanceOf('ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository', $this->sut);
    }

    public function test_returns_model()
    {
        $modelInstance = $this->sut->getModel();

        $this->assertInstanceOf('Database\Tests\Models\User', $modelInstance);
    }

    public function test_all_returns_collection_instance()
    {
        $result = $this->sut->all();

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }

    public function test_paginate_returns_paginate_instance()
    {
        $result = $this->sut->paginate();

        $this->assertInstanceOf('Illuminate\Contracts\Pagination\Paginator', $result);
    }

    public function test_creates_model()
    {
        $result = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $result);
        $this->assertInternalType('int', $result->id);
        $this->assertEquals('anavalla@suiza.com', $result->email);
    }
}
