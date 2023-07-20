<?php

namespace App\Parser\Infrastructure;

use Closure;
use DateInterval;
use DateTimeInterface;

class Cache
{

    public static function remember(string $key, Closure|DateTimeInterface|DateInterval|int|null $ttl, Closure $callback)
    {
       return \Illuminate\Support\Facades\Cache::remember($key,$ttl,$callback);
    }

}
