<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        if (isEmailConfigured()) {

            // Determine whether it's a user or client based on the input data
            $provider = $this->determineProvider($request->email);

            // Send the password reset link
            try {
                $response = Password::broker($provider)->sendResetLink(
                    $request->only('email')
                );

                if ($response == Password::RESET_LINK_SENT) {
                    Session::flash('message', __($response));
                    return response()->json(['error' => false]);
                } else {
                    return response()->json(['error' => true, 'message' => __($response)]);
                }
            } catch (\Exception $e) {
                // Handle the exception here
                return response()->json(['error' => true, 'message' => 'Password reset link couldn\'t sent, please check email settings.']);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'Password reset link couldn\'t sent, please configure email settings.']);
        }
    }
    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function ResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);
        $provider = $this->determineProvider($request->email);
        if ($provider == 'users') {
            $status = Password::broker('users')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    if (isEmailConfigured()) {
                        event(new PasswordReset($user));
                    }
                }
            );
        } else {
            $status = Password::broker('clients')->reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (Client $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();
                    if (isEmailConfigured()) {
                        event(new PasswordReset($user));
                    }
                }
            );
        }

        if ($status === Password::PASSWORD_RESET) {
            Session::flash('message', __($status));
            return response()->json(['error' => false]);
        } else {
            return response()->json(['error' => true, 'message' => __($status)]);
        }
    }

    protected function determineProvider($email)
    {
        // Determine whether the email belongs to a user or a client
        // You can customize this logic based on your application's requirements
        return User::where('email', $email)->exists() ? 'users' : 'clients';
    }
}
