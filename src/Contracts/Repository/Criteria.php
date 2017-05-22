<?php

namespace Ablunier\Laravel\Database\Contracts\Repository;

interface Criteria
{
    /**
     * @param $model
     * @param Repository $repository
     *
     * @return mixed
     */
    public function apply($model, Repository $repository);
}
