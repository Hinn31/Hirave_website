<head>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>

@extends('layouts.master')
@section('title', 'Payment')
@section('content')

    <div class="payment">
        <form action="#" method="POST" class="payment__form">
            @csrf
            <div class="payment__form-section">
                @include('components.payment-form')
            </div>

            <div class="payment__summary">
                @include('components.order-summary')
                @include('components.payment-method')

                <div class="payment__submit">
                    <button type="submit" class="payment__submit-btn">Payment</button>
                </div>
            </div>
        </form>
    </div>
@endsection
