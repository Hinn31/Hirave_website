<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify_email');
    }

    public function verify(Request $request)
    {
        $user = Auth::user();

        if ($request->route('id') != $user->getKey()) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect('/dashboard')->with('message', 'Your email is already verified.');
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect('/dashboard')->with('message', 'Your email has been verified!');
    }

    public function send(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect('/dashboard');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}

