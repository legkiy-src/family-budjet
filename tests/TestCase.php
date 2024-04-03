<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function asUser(string $login) : void
    {
        $user = User::where('name', '=', $login)->first();

        Auth::shouldReceive('user')
            ->andReturn($user);
    }
}
