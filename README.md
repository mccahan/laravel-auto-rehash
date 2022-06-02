# Laravel Auto Rehash

The Laravel documentation makes reference to [checking whether rehashing is necessary on authentication](https://laravel.com/docs/9.x/hashing#determining-if-a-password-needs-to-be-rehashed) but leaves the process itself as an exercise to the reader. This library listens to the `Illuminate\Auth\Events\Attempting` emitted by some authentication techniques and automatically rehashes passwords as necessary when users log in, achieving a rolling password hash upgrade.

## Installation

`composer require mccahan/laravel-auto-rehash`

## Usage

If you only need to listen to default `Attempting` events, you're all set.

## Custom Event

The library includes a custom event you can dispatch if you want to automatically rehash passwords when you have user credentials in-hand but don't want to use the existing `Attempting` event (e.g. if you have other listeners on that event you don't want to fire).

To use, include the event class:

```php
use McCahan\LaravelAutoRehash\Events\ValidUserCredentials;
```

Then dispatch where necessary, including the password and your User model:

```php
// Announce that we have some valid credentials in hand for a valid user
event(new ValidUserCredentials($user, $request->get('password')));
```

## Standing on the Shoulders of Giants

Credit to [SamAsEnd/laravel-needs-auto-rehash](https://github.com/SamAsEnd/laravel-needs-auto-rehash) for their library that feels more robust but didn't easily have custom event support I need.
