@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="forgot-password">
    <form action="{{ route('sendOtp') }}" method="POST" class="forgot-password__form">
        @csrf
        <h3 class="forgot-password__title">Forgot password</h3>
        <p class="forgot-password__description">Enter your email for the verification proccess,we will send 4 digits code to your email.</p>
        <div class="forgot-password__description">
            <label class="forgot-password__label">Email</label>
            <input type="email" name="email" class="forgot-password__input" placeholder="Enter your email..." required>
            @error('email') <p style="color:red">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="forgot-password__button" >CONTINUE</button>
    </form>
</div>
@endsection
