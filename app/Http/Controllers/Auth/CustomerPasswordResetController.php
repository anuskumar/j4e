<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class CustomerPasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.passwords.forgot');
    }

    public function sendCode(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($validated['email']));
        $throttleKey = 'password-reset-code:' . $email;

        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            return back()
                ->withInput()
                ->withErrors([
                    'email' => "Too many reset attempts. Please try again in {$seconds} seconds.",
                ]);
        }

        RateLimiter::hit($throttleKey, 900);

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if ($user) {
            try {
                $code = PasswordResetCode::createForEmail($email);
                $this->sendResetCodeEmail($user, $code);
            } catch (\Throwable $e) {
                report($e);

                return back()
                    ->withInput()
                    ->withErrors(['email' => 'Unable to send reset code right now. Please try again later.']);
            }
        }

        $request->session()->put('password_reset_email', $email);

        return redirect()
            ->route('password.reset.form')
            ->with('status', 'If an account exists for that email, a 6-digit reset code has been sent.');
    }

    public function showResetForm(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()
                ->route('password.forgot')
                ->withErrors(['email' => 'Please request a reset code first.']);
        }

        return view('auth.passwords.reset_code', compact('email'));
    }

    public function resetPassword(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()
                ->route('password.forgot')
                ->withErrors(['email' => 'Your reset session has expired. Please request a new code.']);
        }

        $validated = $request->validate([
            'code' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'code.required' => 'Please enter the 6-digit code from your email.',
            'code.size' => 'The reset code must be exactly 6 digits.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $resetCode = PasswordResetCode::verify($email, $validated['code']);

        if (! $resetCode) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['code' => 'Invalid or expired reset code. Please request a new one.']);
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $user) {
            return redirect()
                ->route('password.forgot')
                ->withErrors(['email' => 'No account was found for this reset request.']);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        $resetCode->markUsed();
        PasswordResetCode::where('email', $email)->delete();

        $request->session()->forget('password_reset_email');

        return redirect()
            ->route('login')
            ->with('status', 'Your password has been reset successfully. You can now sign in.');
    }

    public function resendCode(Request $request)
    {
        $email = $request->session()->get('password_reset_email');

        if (! $email) {
            return redirect()
                ->route('password.forgot')
                ->withErrors(['email' => 'Please enter your email to receive a reset code.']);
        }

        $request->merge(['email' => $email]);

        return $this->sendCode($request);
    }

    private function sendResetCodeEmail(User $user, string $code): void
    {
        $appName = config('app.name', 'Mastro Tickets');
        $logoUrl = \App\Models\CompanySettings::appLogoUrl();

        $html = view('emails.password_reset_code', [
            'user' => $user,
            'code' => $code,
            'appName' => $appName,
            'logoUrl' => $logoUrl,
            'expiresMinutes' => 15,
        ])->render();

        Mail::html($html, function ($message) use ($user, $appName) {
            $message->to($user->email)
                ->subject($appName . ' — Password Reset Code');
        });
    }
}
