<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'password' => ['required', 'string'],
        ];

        if (env('USER_LOGIN_METHOD', 'email') === 'email') {
            $rules['email'] = ['required', 'string', 'email'];
        }

        if (env('USER_LOGIN_METHOD', 'email') === 'username') {
            $rules['username'] = ['required', 'string'];
        }

        return $rules;
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (env('USER_LOGIN_METHOD', 'email') === 'email') {
            if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'email' => trans('auth.failed'),
                ]);
            }
        }

        if (env('USER_LOGIN_METHOD', 'email') === 'username') {
            if (! Auth::attempt($this->only('username', 'password'), $this->boolean('remember'))) {
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'username' => trans('auth.failed'),
                ]);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        if (env('USER_LOGIN_METHOD', 'email') === 'email') {
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        if (env('USER_LOGIN_METHOD', 'email') === 'username') {
            throw ValidationException::withMessages([
                'username' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        if (env('USER_LOGIN_METHOD', 'email') === 'username') {
            return Str::transliterate(Str::lower($this->string('username')) . '|' . $this->ip());
        }

        if (env('USER_LOGIN_METHOD', 'email') === 'username') {
            return Str::transliterate(Str::lower($this->string('username')) . '|' . $this->ip());
        }
    }
}
