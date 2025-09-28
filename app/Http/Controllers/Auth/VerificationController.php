<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     */
    public function show(Request $request): View | RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        if (!$request->session()->has('user_id')) {
            return redirect()->route('register');
        }

        return view('auth.verify-code');
    }

    /**
     * Mark the user's email address as verified.
     */
    public function verifyEmail(Request $request): RedirectResponse
    {
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            return redirect()->route('login')->withErrors([
                'email' => 'Invalid verification link.',
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Your email has been verified!');
    }

    /**
     * Handle the verification code submission.
     */
    public function verifyCode(Request $request): RedirectResponse
    {
        if (!$request->session()->has('user_id') || !$request->session()->has('verification_code')) {
            return redirect()->route('register')->withErrors([
                'email' => 'Your registration session has expired. Please try again.',
            ]);
        }

        $request->validate([
            'code' => ['required', 'string', 'min:6', 'max:6'],
        ]);

        if ($request->session()->get('verification_code') != $request->code) {
            return back()->withErrors([
                'code' => 'The provided code is incorrect.',
            ]);
        }

        $user = User::find($request->session()->get('user_id'));

        if (!$user) {
             return redirect()->route('register')->withErrors([
                'email' => 'User not found. Please register again.',
            ]);
        }

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        Auth::login($user);

        $request->session()->forget(['user_id', 'verification_code']);

        return redirect()->route('dashboard')->with('status', 'Your account has been successfully created and verified!');
    }

    /**
     * Resend the email verification notification.
     */
    public function resend(Request $request): RedirectResponse
    {
        if (!$request->session()->has('user_id')) {
            return redirect()->route('register')->withErrors([
                'email' => 'Your registration session has expired. Please try again.',
            ]);
        }
        
        $user = User::find($request->session()->get('user_id'));

        if (!$user) {
             return redirect()->route('register')->withErrors([
                'email' => 'User not found. Please register again.',
            ]);
        }

        $newVerificationCode = random_int(100000, 999999);
        $request->session()->put('verification_code', $newVerificationCode);

        Mail::to($user->email)->send(new VerificationCodeMail($newVerificationCode));

        return back()->with('status', 'A new verification code has been sent to your email address.');
    }
}
