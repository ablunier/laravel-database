<?php

namespace Ablunier\Laravel\Database\Contracts\Repository;

interface HasCache
{
    /**
     * Enable or disable caching model queries.
     *
     * @return bool
     */
    public function cache();

    /**
     * Set cache lifetime.
     *
     * @return int
     */
    public function cacheLifetime();
}
