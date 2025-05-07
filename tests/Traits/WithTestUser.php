<?php

namespace Tests\Traits;

use App\Models\User;

trait WithTestUser
{
    protected function getTestUser(): User
    {
        return User::where('email', 'testuser@example.com')->firstOrFail();
    }

    protected function loginAsTestUser(): User
    {
        $user = $this->getTestUser();
        $this->actingAs($user);
        return $user;
    }
}