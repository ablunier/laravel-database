<?php
namespace ANavallaSuiza\Laravel\Database\Contracts\Repository;

interface Cache
{
    /**
     * @param bool $status
     * @return $this
     */
    public function skipCache($status = true);

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
