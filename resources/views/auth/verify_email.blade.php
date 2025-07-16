@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="verify-container">
    <h2>Verify Your Email Address</h2>
    <p>
        Before continuing, please check your email for a verification link.
        If you did not receive the email, click the button below to request another.
    </p>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit" class="verify-btn">Resend Verification Email</button>
    </form>
</div>
@endsection
