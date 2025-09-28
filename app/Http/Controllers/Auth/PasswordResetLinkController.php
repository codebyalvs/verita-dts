<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $verificationCode = random_int(100000, 999999);

        $request->session()->put('password_reset_data', [
            'email' => $request->email,
            'verification_code' => $verificationCode,
        ]);

        try {
            Mail::to($request->email)->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Could not send verification email. Please try again later.',
            ]);
        }

        return redirect()->route('password.code')->with('status', 'A verification code has been sent to your email.');
    }

    /**
     * Display the verification code entry view.
     */
    public function showCodeForm()
    {
        if (!session()->has('password_reset_data')) {
            return redirect()->route('password.request');
        }
        return view('auth.password-code');
    }

    /**
     * Verify the verification code.
     */
    public function verifyCode(Request $request)
    {
        $request->validate(['code' => ['required', 'numeric', 'digits:6']]);

        $resetData = $request->session()->get('password_reset_data');

        if (!$resetData || $resetData['verification_code'] != $request->code) {
            return back()->withErrors(['code' => 'The provided verification code is incorrect.']);
        }

        $request->session()->put('password_reset_verified', true);

        return redirect()->route('password.reset');
    }

    /**
     * Resend the verification code.
     */
    public function resendCode(Request $request): RedirectResponse
    {
        $resetData = $request->session()->get('password_reset_data');

        if (!$resetData) {
            return redirect()->route('password.request');
        }

        $verificationCode = random_int(100000, 999999);
        $resetData['verification_code'] = $verificationCode;
        $request->session()->put('password_reset_data', $resetData);

        try {
            Mail::to($resetData['email'])->send(new VerificationCodeMail($verificationCode));
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Could not send verification email. Please try again.',
            ]);
        }

        return back()->with('status', 'A new verification code has been sent to your email address.');
    }
}
