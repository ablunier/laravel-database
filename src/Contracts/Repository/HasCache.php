<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Repository;

interface HasCache
{
    /**
     * Enable or disable caching model queries
     *
     * @return boolean
     */
    public function cache();

    /**
     * Set cache lifetime
     *
     * @return integer
     */
    public function cacheLifetime();
}
