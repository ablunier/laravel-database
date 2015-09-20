<?php
namespace ANavallaSuiza\Laravel\Database\Repository\Criteria;

use ANavallaSuiza\Laravel\Database\Contracts\Repository\Criteria;

class WithCriteria implements Criteria
{
    protected $with = array();

    public function __construct(array $with)
    {
        $this->with = $with;
    }

    public function apply($model, Repository $repository)
    {
        $this->model->with($this->with);
    }
}
