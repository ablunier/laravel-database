<?php
namespace Database\Tests\Repository;

use Database\Tests\TestBase;
use ANavallaSuiza\Laravel\Database\Repository\Eloquent\Repository;
use ANavallaSuiza\Laravel\Database\Repository\Exceptions\RepositoryException;

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

    public function test_updates_model()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $this->assertEquals('Ana Valla Suiza', $model->name);

        $result = $this->sut->update([
            'name' => 'Ana Valla'
        ], $model->id);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Model', $result);
        $this->assertEquals('Ana Valla', $result->name);
    }

    public function test_update_throws_exception()
    {
        $this->setExpectedException(RepositoryException::class);

        $result = $this->sut->update([
            'name' => 'Ana Valla'
        ], 25);
    }

    public function test_deletes_model()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $this->assertEquals('Ana Valla Suiza', $model->name);

        $this->sut->delete($model->id);

        $result = $this->sut->find($model->id);

        $this->assertEquals(null, $result);
    }

    public function test_finds_model_by_identifier()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $result = $this->sut->find($model->id);

        $this->assertInstanceOf('Database\Tests\Models\User', $result);
    }

    public function test_finds_model_by_identifier_or_fails()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $modelId = $model->id;

        $result = $this->sut->findOrFail($modelId);

        $this->assertInstanceOf('Database\Tests\Models\User', $result);

        $this->sut->delete($modelId);

        $this->setExpectedException(\Exception::class);

        $this->sut->findOrFail($modelId);
    }

    public function test_finds_model_by_field()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $result = $this->sut->findBy('email', 'anavalla@suiza.com');

        $this->assertInstanceOf('Database\Tests\Models\User', $result);
    }

    public function test_finds_model_by_field_or_fails()
    {
        $model = $this->sut->create([
            'name' => 'Ana Valla Suiza',
            'email' => 'anavalla@suiza.com',
            'password' => '123456'
        ]);

        $result = $this->sut->findByOrFail('email', 'anavalla@suiza.com');

        $this->assertInstanceOf('Database\Tests\Models\User', $result);

        $this->sut->delete($model->id);

        $this->setExpectedException(\Exception::class);

        $this->sut->findByOrFail('email', 'anavalla@suiza.com');
    }

    public function test_find_all_by_field()
    {
        $result = $this->sut->findAllBy('email', 'anavalla@suiza.com');

        $this->assertInstanceOf('Illuminate\Support\Collection', $result);
    }
}
