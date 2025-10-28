<?php

namespace App\Services\Cache\Drivers;

use App\Contracts\Cache\ICacheService;
use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository;

class FileCacheService implements ICacheService
{
    protected Repository $driver;

    /**
     * @param CacheManager $driver
     */
    public function __construct(CacheManager $driver)
    {
        $this->driver = $driver->driver('file');
    }

    public function remember($key, $ttl, Closure $callback)
    {
        return $this->driver->remember($key, $ttl, $callback);
    }

    public function rememberForever($key, Closure $callback)
    {
        return $this->driver->rememberForever($key, $callback);
    }

    public function forget($key)
    {
        return $this->driver->forget($key);
    }

    public function get(string $key, mixed $default = null)
    {
        return $this->driver->get($key, $default);
    }

    public function tags(mixed $names)
    {
        //not supported by file-cache. maybe customizable
        return $this->driver;
    }

    public function flush()
    {
        return $this->driver->flush();
    }
}
