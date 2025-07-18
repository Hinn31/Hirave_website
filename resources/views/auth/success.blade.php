@extends('layouts.app')

@section('title', 'Success')

@section('content')
  <div class="reset-success">
    <div class="reset-success__content">
        <div class="reset-success__icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <h2 class="reset-success__title">Successfully</h2>
        <p class="reset-success__message">Your password has been reset successfully</p>

        <a href="{{route ('login')}}" class="reset-success__button">CONTINUE</a>
    </div>
</div>
@endsection
