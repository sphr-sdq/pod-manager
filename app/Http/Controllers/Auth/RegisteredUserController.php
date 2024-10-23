<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateProfilePicture;
use App\Models\otpModel;
use App\Models\User;
use Carbon\Carbon;
use App\Exceptions\OtpTimeoutException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Ichtrojan\Otp\Otp;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    public function createOTP(Request $request): void
    {


        $validated = $request->validate([
            "phoneNumber" => "required|regex:/(09\d{9})/"
        ], [
            "required" => "شماره موبایل اجباری است.",
            "regex" => "شماره موبایل نامعتبر است."
        ]);

        $userExists = User::where('phoneNumber', $validated['phoneNumber'])->exists();
        if ($userExists) {
            throw ValidationException::withMessages([
                'userExist' => "این شماره قبلا به ثبت رسیده است"
            ]);
        }

        $record = otpModel::where('identifier', $validated['phoneNumber'])->where('valid', '=', true)->first();

        if ($record && $record->created_at->diffInSeconds(Carbon::now()) < 90) {
            throw new OtpTimeoutException(90 - $record->created_at->diffInSeconds(Carbon::now()));
        }

        $otp = (new Otp)->generate($validated["phoneNumber"], 'numeric', 5, 15);
        ds($otp);

    }

    public function verify(Request $request)
    {

        $validated = $request->validate([
            "otpCode" => 'required|size:5',
            "phoneNumber" => 'required'
        ],
            [
                "required" => "کد تایید شماره موبایل اجباری است.",
                "size" => "کد به درستی وارد نشده است."
            ]);
        $check = (new Otp)->validate($validated['phoneNumber'], $validated['otpCode']);
        ds($check);
        if (!$check->status) {
            if ($check->message === "OTP is not valid") {
                throw  ValidationException::withMessages([
                    'invalid' => 'کد وارد شده نا‌معتبر است'
                ]);
            } elseif ($check->message === "OTP does not exist") {
                throw ValidationException::withMessages([
                    "invalid" => "کد وارد شده صحیح نمی باشد "
                ]);
            }

        }


    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validated  = $request->validate([
            'phoneNumber' => "required|regex:/(09\d{9})/",
            'password' => ['required', Rules\Password::defaults()],
        ] ,
        [
            'required' => 'پر کردن فیلد رمز عبور الزامی است.',
            'password' => [
                'min' => 'رمز عبور باید حداقل :min کاراکتر باشد.',
                'letters' => 'رمز عبور باید حداقل یک حرف داشته باشد.',
                'mixed' => 'رمز عبور باید شامل حروف بزرگ و کوچک باشد.',
                'numbers' => 'رمز عبور باید حداقل یک عدد داشته باشد.',
                'symbols' => 'رمز عبور باید حداقل یک کاراکتر خاص (مانند !@#$) داشته باشد.',
                'uncompromised' => 'این رمز عبور در یک نشت اطلاعات قبلی یافت شده است. لطفاً یک رمز عبور دیگر انتخاب کنید.',
            ],
        ]
        );

        $user = User::create([
            'phoneNumber' => $validated['phoneNumber'],
            'password' => Hash::make($validated['password']),
        ]);

//        GenerateProfilePicture::dispatch($user)->onQueue('profile-pictures');
        event(new Registered($user));

        Auth::login($user);

        return redirect(route('home', absolute: false));
    }
}
