<?php

namespace McCahan\LaravelAutoRehash;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use McCahan\LaravelAutoRehash\Listeners\AuthenticationEventSubscriber;

class AutoRehashServiceProvider extends ServiceProvider {
    protected $subscribe = [
        AuthenticationEventSubscriber::class,
    ];
}
