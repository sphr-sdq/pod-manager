<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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

    public function createOTP(Request $request)  : void
    {
        sleep(2);


        $validated = $request->validate([
            "phoneNumber" => "required|regex:/(0?9\d{9})/"
        ],[
            "required" => "شماره موبایل اجباری است.",
            "regex" => "شماره موبایل نامعتبر است."
        ]);

        // TODO
        //  1) create another post route for validating otp code
        //  2) fix bugs in state manager in vue js for returning or even if user changes the routes returns to the same state of login page using pinia.
        //  3) fix 09--- and 9--- these are are the same. right now user can create two account with one phone number
        $record = otpModel::where('identifier' , $validated['phoneNumber'])->where('valid' ,'=' , true )->first();
        ds($record);
        if($record && $record->created_at->diffInSeconds(Carbon::now()) < 90){
           throw new OtpTimeoutException(90 - $record->created_at->diffInSeconds(Carbon::now()));
        }


        $otp = (new Otp)->generate($validated["phoneNumber"], 'numeric', 5, 15);
        ds($otp);

    }

    public function verify(Request $request) : void
    {

        $validated = $request->validate([
            "otpCode" => 'required|size:5',
            "phoneNumber" => 'required'
        ] ,
        [
            "required" => "کد تایید شماره موبایل اجیاری است.",
            "size" => "کد به درستی وارد نشده است."
        ]);
        $check = (new Otp)->validate($validated['phoneNumber'], $validated['otpCode']);
        ds($check);

    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
