<?php

namespace App\Queue\Messages;

use Illuminate\Support\Str;

class BaseMessage
{
    public string $job='custom';
    public string $uuid;

    public function __construct()
    {
        $this->uuid = Str::uuid();
    }
}
