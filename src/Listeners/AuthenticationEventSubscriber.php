<?php

namespace McCahan\LaravelAutoRehash\Listeners;

use McCahan\LaravelAutoRehash\Events\ValidUserCredentials;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\Events\Attempting;

class AuthenticationEventSubscriber
{
    /**
     * When we have valid credentials on hand, check to see if it needs to be
     * re-hashed.
     *
     * @param McCahan\LaravelAutoRehash\Events\ValidUserCredentials $event
     * @return void
     */
    public function handleValidUserCredentials($event) {
        if (Hash::needsRehash($event->user->password)) {
            $hash = Hash::make($event->password);
            $event->user->password = $hash;
            $event->user->save();
        }
    }

    /**
     * When the user attempts a login, check to see if the credentials are valid
     * and, if so, check to see if the password needs to be rehashed.
     *
     * @param Illuminate\Auth\Events\Attempting
     * @return void
     */
    public function handleLoginAttempt($event) {
        $guard = auth($event->guard);
        if (!$guard->validate($event->credentials)) return;

        // Get the user by credentials from the guard's provider
        $user = $guard->getProvider()->retrieveByCredentials($event->credentials);
        if (!$user) return;

        if (Hash::needsRehash($user->password)) {
            $hash = Hash::make($event->credentials['password']);
            $user->password = $hash;
            $user->save();
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            ValidUserCredentials::class,
            [AuthenticationEventSubscriber::class, 'handleValidUserCredentials']
        );

        $events->listen(
            Attempting::class,
            [AuthenticationEventSubscriber::class, 'handleLoginAttempt']
        );
    }
}
