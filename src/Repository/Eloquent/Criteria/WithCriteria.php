<?php
namespace ANavallaSuiza\Laravel\Database\Repository\Eloquent\Criteria;

use ANavallaSuiza\Laravel\Database\Contracts\Repository\Criteria;
use ANavallaSuiza\Laravel\Database\Contracts\Repository\Repository;

class WithCriteria implements Criteria
{
    protected $with = array();

    public function __construct(array $with)
    {
        $this->with = $with;
    }

    public function apply($model, Repository $repository)
    {
        return $model->with($this->with);
    }
}
