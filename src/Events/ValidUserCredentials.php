<?php

namespace McCahan\LaravelAutoRehash\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth;

class ValidUserCredentials {
    use Dispatchable;

    public $user;
    public $password;

    public function __construct(Authenticatable $user, $password) {
        $this->user = $user;
        $this->password = $password;
    }
}
