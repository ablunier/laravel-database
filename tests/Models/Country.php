<?php

namespace Database\Tests\Models;

use Ablunier\Laravel\Database\Contracts\Repository\HasCache;
use Illuminate\Database\Eloquent\Model;

class Country extends Model implements HasCache
{
    /**
     * Enable or disable caching model queries.
     *
     * @return bool
     */
    public function cache()
    {
        return true;
    }

    /**
     * Set cache lifetime.
     *
     * @return int
     */
    public function cacheLifetime()
    {
        return 24 * 60;
    }
}
