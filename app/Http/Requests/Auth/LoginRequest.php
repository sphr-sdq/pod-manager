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
        return [
            'phoneNumber' => ['required', 'string', 'regex:/^09\d{9}$/'],
            'password' => ['required', 'string' , \Illuminate\Validation\Rules\Password::default()],
        ] ;
    }


    public function messages(): array
    {
        return [
            'phoneNumber.required' => 'پر کردن فیلد شماره تلفن الزامی است.',
            'phoneNumber.regex' => 'شماره تلفن باید با 09 شروع شود و شامل 11 رقم باشد.',

            'password.required' => 'پر کردن فیلد رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
            'password.letters' => 'رمز عبور باید حداقل یک حرف داشته باشد.',
            'password.mixed' => 'رمز عبور باید شامل حروف بزرگ و کوچک باشد.',
            'password.numbers' => 'رمز عبور باید حداقل یک عدد داشته باشد.',
            'password.symbols' => 'رمز عبور باید حداقل یک کاراکتر خاص (مانند !@#$) داشته باشد.',
            'password.uncompromised' => 'این رمز عبور در یک نشت اطلاعات قبلی یافت شده است. لطفاً یک رمز عبور دیگر انتخاب کنید.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('phoneNumber', 'password'))) {
//            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'phoneNumber' => 'شماره تلفن یا پسورد اشتباه است.',

            ]);
        }
            // TODO fix this  (RateLimiter)

//        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
//        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
//            return;
//        }
//
//        event(new Lockout($this));
//
//        $seconds = RateLimiter::availableIn($this->throttleKey());
//
//        throw ValidationException::withMessages([
//            'phoneNumber' => trans('auth.throttle', [
//                'seconds' => $seconds,
//                'minutes' => ceil($seconds / 60),
//            ]),
//        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('phoneNumber')).'|'.$this->ip());
    }
}
