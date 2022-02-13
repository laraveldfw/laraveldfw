<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest as BaseRequest;

/**
 * I am deviating slightly from Laravel Breeze's auth flow. I am requiring email verification before any login.
 * Breeze requires that the user be logged in when they verify their email.
 * Since I took away the auto-login functionality after registration I now must manually grab the user on this request
 */
class EmailVerificationRequest extends BaseRequest
{
    /**
     * @var User
     */
    private $user;

    public function user($guard = null)
    {
        if ($this->user) {
            return $this->user;
        }
        if (! $userId = $this->route('id')) {
            return null;
        }

        $this->user = User::findOrFail($userId);

        return $this->user;
    }
}
