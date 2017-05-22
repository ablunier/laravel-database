<?php
namespace Database\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Ablunier\Laravel\Database\Contracts\Repository\HasCache;

class Country extends Model implements HasCache
{
    /**
     * Enable or disable caching model queries
     *
     * @return boolean
     */
    public function cache()
    {
        return true;
    }

    /**
     * Set cache lifetime
     *
     * @return integer
     */
    public function cacheLifetime()
    {
        return 24 * 60;
    }
}
