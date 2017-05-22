<?php

namespace Ablunier\Laravel\Database\Repository\Eloquent\Criteria;

use Ablunier\Laravel\Database\Contracts\Repository\Criteria;
use Ablunier\Laravel\Database\Contracts\Repository\Repository;

class WithCriteria implements Criteria
{
    protected $with = [];

    public function __construct(array $with)
    {
        $this->with = $with;
    }

    public function apply($model, Repository $repository)
    {
        return $model->with($this->with);
    }
}
