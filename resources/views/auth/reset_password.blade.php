@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="new-password">
        <form action="{{ route('forgot.password.reset') }}" method="POST" class="new-password__form">
            @csrf
            <h3 class="new-password__title">New Password</h3>
            <p class="new-password__description">
                Set the new password for your account so you can login and access all features.
            </p>
            <div class="new-password__input-group" style="flex-direction: column;">
                <!-- Enter new password -->
                <label class="new-password__label">Enter new password</label>
                <div class="new-password__input-wrapper">
                    <input type="password" name="password" class="new-password__input" id="password" placeholder="8 symbols at least" required>
                    <span class="new-password__icon" onclick="togglePassword('password', this)">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>

                <!-- Confirm password -->
                <label class="new-password__label">Confirm password</label>
                <div class="new-password__input-wrapper">
                    <input type="password" name="password_confirmation" class="new-password__input" id="confirm-password" placeholder="8 symbols at least" required>
                    <span class="new-password__icon" onclick="togglePassword('confirm-password', this)">
                        <i class="fas fa-eye"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="new-password__button">UPDATE PASSWORD</button>
        </form>
       <script src="{{ asset('js/reset_password.js') }}"></script>

    </div>

@endsection
