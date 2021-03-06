<?php

namespace Ablunier\Laravel\Database\Repository\Eloquent;

use Ablunier\Laravel\Database\Contracts\Repository\Cache as CacheContract;
use Ablunier\Laravel\Database\Contracts\Repository\Repository as RepositoryContract;
use Ablunier\Laravel\Database\Repository\Exceptions\RepositoryException;
use Illuminate\Contracts\Cache\Repository as LaravelCache;
use ReflectionClass;

class Cache implements CacheContract
{
    /**
     * @var RepositoryContract
     */
    protected $repository;

    /**
     * @var LaravelCache
     */
    protected $cache;

    /**
     * @var bool
     */
    protected $skipCache = false;

    /**
     * @var bool
     */
    protected $refreshCache = false;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $lifetime;

    public function __construct(RepositoryContract $repository, LaravelCache $cache)
    {
        $this->repository = $repository;
        $this->cache = $cache;
    }

    public function __call($method, $params)
    {
        if (!method_exists($this->repository, $method)) {
            throw new RepositoryException("Method $method not found on repository");
        }

        if ($this->skipCache === true || config('laravel-database.cache') === false) {
            return call_user_func_array([$this->repository, $method], $params);
        } else {
            if (empty($this->key)) {
                $this->cacheKey($this->generateKey($method, $params));
            }
            $key = $this->key;
            unset($this->key);

            if ($this->refreshCache) {
                $this->cache->forget($key);

                $this->refreshCache = false;
            }

            if (empty($this->lifetime)) {
                $this->cacheLifetime($this->repository->getModel()->cacheLifetime());
            }
            $lifetime = $this->lifetime;
            unset($this->lifetime);

            return $this->cache->remember($key, $lifetime, function () use ($method, $params) {
                return call_user_func_array([$this->repository, $method], $params);
            });
        }
    }

    protected function generateKey($method, $params)
    {
        $className = (new ReflectionClass($this->repository->getModel()))->getShortName();

        return strtolower($className).'.'.strtolower($method).'.'.md5(serialize($params));
    }

    public function skipCache($status = true)
    {
        $this->skipCache = $status;

        return $this;
    }

    public function refreshCache()
    {
        $this->refreshCache = true;

        return $this;
    }

    public function cacheKey($name)
    {
        $this->key = $name;

        return $this;
    }

    public function cacheLifetime($minutes)
    {
        $this->lifetime = $minutes;

        return $this;
    }
}
