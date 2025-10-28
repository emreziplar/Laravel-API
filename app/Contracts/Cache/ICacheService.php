<?php

namespace App\Contracts\Cache;

use Closure;

interface ICacheService
{
    public function remember($key, $ttl, Closure $callback);

    public function rememberForever($key, Closure $callback);

    public function forget($key);

    public function get(string $key, mixed $default = null);

    /**
     * @param mixed $names
     * @return \Illuminate\Cache\TaggedCache
     */
    public function tags(mixed $names);

    public function flush();
}
