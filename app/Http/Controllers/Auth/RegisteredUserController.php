<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use App\Mail\VerificationCodeMail;
use Exception;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email:rfc,dns', 'max:255', 'unique:'.User::class, 'regex:/@(gmail|google)\.com$/i'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verificationCode = random_int(100000, 999999);

        // Store registration data in session instead of creating the user
        $request->session()->put('registration_data', [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
        ]);

        try {
            // Send verification email
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        } catch (Exception $e) {
            // If email sending fails, redirect back with an error
            return back()->withErrors([
                'email' => 'Could not send verification email. Please check your email address and try again.',
            ]);
        }

        // Redirect to the verification notice page
        return redirect()->route('verification.notice');
    }

    /**
     * Display the verification notice view.
     */
    public function showVerificationForm()
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('register');
        }
        return view('auth.verify');
    }

    /**
     * Handle the verification of the email code.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'numeric', 'digits:6'],
        ]);

        $registrationData = $request->session()->get('registration_data');

        if (!$registrationData || $registrationData['verification_code'] != $request->code) {
            return back()->withErrors([
                'code' => 'The provided verification code is incorrect.',
            ]);
        }

        $user = User::create([
            'first_name' => $registrationData['first_name'],
            'last_name' => $registrationData['last_name'],
            'middle_name' => $registrationData['middle_name'],
            'email' => $registrationData['email'],
            'password' => $registrationData['password'],
            'email_verified_at' => now(), // Mark email as verified
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Clear the registration data from the session
        $request->session()->forget('registration_data');

        return redirect()->route('dashboard')->with('status', 'Your account has been successfully created and verified!');
    }

    /**
     * Resend the verification email.
     */
    public function resend(Request $request): RedirectResponse
    {
        $registrationData = $request->session()->get('registration_data');

        if (!$registrationData) {
            return redirect()->route('register');
        }

        $verificationCode = random_int(100000, 999999);

        $registrationData['verification_code'] = $verificationCode;

        $request->session()->put('registration_data', $registrationData);

        try {
            Mail::to($registrationData['email'])->send(new VerificationCodeMail($verificationCode));
        } catch (Exception $e) {
            return back()->withErrors([
                'email' => 'Could not send verification email. Please check your email address and try again.',
            ]);
        }

        return back()->with('status', 'A new verification code has been sent to your email address.');
    }
}
