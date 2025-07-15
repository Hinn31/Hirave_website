
@extends('layouts.app')

@section('title', 'Verification')

@section('content')
    <div class="verification">
        <form action="{{ route('forgot.password.verify') }}" method="POST" class="verification__form">
            @csrf
            <h3 class="verification__title">Verification</h3>
            <p class="verification__description">Enter your 4 digits code that you received on your email.</p>
            <input type="hidden" name="email" value="{{ $email ?? session('email') }}">
            <input type="hidden" name="otp" id="otp">

            <div class="verification__input-group">
                <input type="number" maxlength="1" id="digit1" class="verification__input">
                <input type="number" maxlength="1" id="digit2" class="verification__input">
                <input type="number" maxlength="1" id="digit3" class="verification__input">
                <input type="number" maxlength="1" id="digit4" class="verification__input">
            </div>
            @error('otp') <p style="color:red">{{ $message }}</p> @enderror

            <p id="verification__countdown" class="verification__countdown">01:00</p>
            <button type="submit" class="verification__button">CONTINUE</button>
            <p class="verification__resend">
                If you didn’t receive a code! <a href="{{ route('forgot.password.resend') }}" id="resend-link">Resend</a>
            </p>
        </form>

        <script>
            const form = document.querySelector('.verification__form');
            form.addEventListener('submit', function() {
                const otp = digit1.value + digit2.value + digit3.value + digit4.value;
                document.getElementById('otp').value = otp;
            });

            let seconds = 60;
            const countdown = document.getElementById('verification__countdown');
            setInterval(() => {
                seconds--;
                let m = Math.floor(seconds / 60);
                let s = seconds % 60;
                countdown.textContent = `${m.toString().padStart(2,'0')}:${s.toString().padStart(2,'0')}`;
                if (seconds <= 0) countdown.textContent = 'Expired!';
            }, 1000);
        </script>
    </div>
@endsection
