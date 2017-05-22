<?php
namespace Ablunier\Laravel\Database\Contracts\Repository;

interface Cache
{
    /**
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true);

    /**
     * @return $this
     */
    public function refreshCache();

    /**
     * @param string $name
     * @return $this
     */
    public function cacheKey($name);

    /**
     * @param integer $minutes
     * @return $this
     */
    public function cacheLifetime($minutes);
}
