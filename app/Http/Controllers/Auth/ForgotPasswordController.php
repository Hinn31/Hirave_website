<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ForgotPasswordController extends Controller
{
    //POST Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(1000, 9999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => now()]
        );

        Mail::raw("Your OTP is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Your password reset OTP');
        });

        Session::put('reset_email', $request->email);

        return redirect()->route('verify.form')
                         ->with('message', 'OTP has been sent!');
    }

    //Get Verify OTP
    public function showVerifyForm()
    {
        $email = Session::get('reset_email');
        if (!$email) {
            return redirect()->route('forgot.password.form')->withErrors(['email' => 'No email found.']);
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();
        $createdAt = $record ? $record->created_at : now();

        return view('auth.verification', compact('email', 'createdAt'));
    }

    //POST Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        if (Carbon::parse($record->created_at)->addMinutes(1)->isPast()) {
            return back()->withErrors(['otp' => 'OTP expired.']);
        }

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('reset.form');
    }

    //GET and POST OTP
    public function resendOtp()
    {
        $email = Session::get('reset_email');
        if (!$email) {
            return redirect()->route('forgot.password.form')->withErrors(['email' => 'No email found.']);
        }

        $otp = rand(1000, 9999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        Mail::raw("Your new OTP is: $otp", function ($message) use ($email) {
            $message->to($email)->subject('Your new OTP');
        });

        return back()->with('message', 'A new OTP has been sent!');
    }

    //GET Reset Password
    public function showResetForm()
    {
        $email = Session::get('reset_email');
        if (!$email) {
            return redirect()->route('forgot.password.form')->withErrors(['email' => 'No email found.']);
        }

        return view('auth.reset_password', compact('email'));
    }

    //POST Reset Password
   public function resetPassword(Request $request)
    {
        $email = Session::get('reset_email');
        if (!$email) {
            return redirect()->route('forgot.password.form')->withErrors(['email' => 'No email found.']);
        }

        $request->validate(
            [
            'password' => 'required|confirmed|min:8',
            ],
            [
                'password.required' => 'Password is required.',
                'password.confirmed' => 'Password and confirm password should be same.',
                'password.min' => 'Password should be at least 8 characters.',
            ]
    );

        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        Session::forget('reset_email');

        return redirect()->route('forgot.password.success')
            ->with('status', 'Password reset successfully!');
    }
}
