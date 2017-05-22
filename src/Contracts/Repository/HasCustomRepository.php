<?php

namespace Ablunier\Laravel\Database\Contracts\Repository;

interface HasCustomRepository
{
    /**
     * Get Eloquent Model custom repository.
     *
     * @return string
     */
    public function repository();
}
